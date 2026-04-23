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
        $booking = Booking::with(['city.country', 'hotel'])->where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status === 'paid') {
            return redirect()->route('bookings.show', $id)->with('error', 'This booking is already paid.');
        }

        $hotels = Hotel::where('city_id', $booking->city_id)->get();

        return view('payment.show', compact('booking', 'hotels'));
    }

    public function store(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'departure_country' => 'required|string|max:100',
            'departure_city' => 'required|string|max:100',
            'hotel_id' => 'required|exists:hotels,id',
            'is_hotel_paid' => 'required|boolean',
        ]);

        // Verify hotel belongs to the booking's city
        $hotel = Hotel::where('id', $validated['hotel_id'])
            ->where('city_id', $booking->city_id)
            ->firstOrFail();

        // Calculate hotel budget based on selected hotel and booking duration/passengers
        $hotelBudget = $hotel->price_per_night * $booking->duration * $booking->passengers;

        // Create payment record
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'booking_id' => $booking->id,
            'start_date' => $validated['start_date'],
            'departure_country' => $validated['departure_country'],
            'departure_city' => $validated['departure_city'],
            'is_hotel_paid' => $validated['is_hotel_paid'],
        ]);

        // Update booking with selected hotel and calculated hotel budget
        $booking->update([
            'hotel_id' => $validated['hotel_id'],
            'hotel_budget' => $hotelBudget,
            'status' => 'paid',
        ]);

        return redirect()->route('payment.ticket', $booking->id);
    }

    public function ticket($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        $payment = Payment::where('booking_id', $booking->id)->where('user_id', auth()->id())->latest()->firstOrFail();
        $payment->load(['booking.city.country', 'booking.hotel', 'user']);

        return view('payment.ticket', compact('payment'));
    }
}

