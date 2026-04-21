<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

        $flights = [
            ['airline' => 'Air France', 'duration' => '2h 30m', 'departure' => '06:00', 'arrival' => '08:30', 'price' => 189],
            ['airline' => 'Lufthansa', 'duration' => '3h 10m', 'departure' => '09:15', 'arrival' => '12:25', 'price' => 234],
            ['airline' => 'EasyJet', 'duration' => '2h 50m', 'departure' => '14:00', 'arrival' => '16:50', 'price' => 149],
            ['airline' => 'Emirates', 'duration' => '4h 00m', 'departure' => '20:30', 'arrival' => '00:30', 'price' => 312],
        ];

        return view('payment.show', compact('booking', 'flights'));
    }

    public function store(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'departure_country' => 'required|string|max:100',
            'departure_city' => 'required|string|max:100',
            'is_flight_paid' => 'required|boolean',
            'is_hotel_paid' => 'required|boolean',
            'airline' => 'nullable|string|max:100',
            'flight_departure' => 'nullable|string|max:10',
            'flight_arrival' => 'nullable|string|max:10',
            'flight_duration' => 'nullable|string|max:50',
        ]);

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'booking_id' => $booking->id,
            'start_date' => $validated['start_date'],
            'departure_country' => $validated['departure_country'],
            'departure_city' => $validated['departure_city'],
            'is_flight_paid' => $validated['is_flight_paid'],
            'is_hotel_paid' => $validated['is_hotel_paid'],
            'airline' => $validated['airline'],
            'flight_departure' => $validated['flight_departure'],
            'flight_arrival' => $validated['flight_arrival'],
            'flight_duration' => $validated['flight_duration'],
        ]);

        $booking->update(['status' => 'paid']);

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
