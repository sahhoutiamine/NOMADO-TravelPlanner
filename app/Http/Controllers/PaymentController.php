<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show($id)
    {
        $userId = auth()->id();
        $booking = Booking::with(['city.country', 'hotels', 'departureCity'])
            ->where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhereHas('participants', function($q) use ($userId) {
                          $q->where('user_id', $userId);
                      });
            })->findOrFail($id);

        if ($booking->status === 'paid') {
            return redirect()->route('bookings.show', $id)->with('error', 'This booking is already paid.');
        }

        return view('payment.show', compact('booking'));
    }

    public function store(Request $request, $id)
    {
        $userId = auth()->id();
        $booking = Booking::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('participants', function($q) use ($userId) {
                      $q->where('user_id', $userId);
                  });
        })->findOrFail($id);

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        // Determine if flight and hotel should be marked as paid
        $isFlightPaid = !empty($booking->flight_airline);
        $isHotelPaid = (bool) $booking->include_hotel && $booking->hotels()->exists();

        // Calculate total amount paid (flight + hotel)
        $totalAmount = 0;
        if ($isFlightPaid) $totalAmount += $booking->flight_budget;
        if ($isHotelPaid) $totalAmount += $booking->hotel_budget;

        // Create payment record with flight details
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'booking_id' => $booking->id,
            'start_date' => $request->start_date,
            'departure_country' => $booking->departureCity?->country?->name,
            'departure_city' => $booking->departureCity?->name,
            'total_amount' => $totalAmount,
            'is_flight_paid' => $isFlightPaid,
            'is_hotel_paid' => $isHotelPaid,
            'airline' => $booking->flight_airline,
            'flight_duration' => $booking->flight_duration,
            'flight_departure' => $isFlightPaid ? '10:30' : null,
            'flight_arrival' => $isFlightPaid ? '14:45' : null,
        ]);

        // Update booking status
        $booking->update([
            'status' => 'paid',
        ]);

        return redirect()->route('payment.ticket', $booking->id);
    }

    public function ticket($id)
    {
        $userId = auth()->id();
        $booking = Booking::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('participants', function($q) use ($userId) {
                      $q->where('user_id', $userId);
                  });
        })->findOrFail($id);

        $payment = Payment::where('booking_id', $booking->id)->latest()->firstOrFail();
        $payment->load(['booking.city.country', 'booking.hotels', 'user']);

        return view('payment.ticket', compact('payment'));
    }
}

