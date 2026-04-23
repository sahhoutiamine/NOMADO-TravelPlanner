<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Place;

class MyBookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['city.country', 'hotel'])->where('user_id', auth()->id())->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['city.country', 'city.places', 'hotel.city'])->where('user_id', auth()->id())->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        // Only allow updates for pending bookings
        if ($booking->status !== 'pending') {
            return response()->json(['error' => 'Cannot modify paid bookings'], 403);
        }

        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'include_hotel' => 'nullable|boolean',
            'selected_place_ids' => 'nullable|string',
        ]);

        // Recalculate budgets based on selections
        $hotel = Hotel::findOrFail($request->hotel_id);
        $hotelCost = $request->include_hotel
            ? ($hotel->price_per_night * $booking->duration * $booking->passengers)
            : 0;

        $placeIds = array_filter(explode(',', $request->selected_place_ids ?? ''));
        $places = Place::whereIn('id', $placeIds)->get();
        $placesCost = $places->sum(fn($p) => $p->min_price * $booking->passengers);

        $remaining = $booking->budget_total - $hotelCost;
        $flightBudget = $remaining * 0.30;
        $miscBudget = $remaining * 0.20;
        $activitiesBudget = $remaining * 0.50;

        // Update booking
        $booking->update([
            'hotel_id' => $request->hotel_id,
            'include_hotel' => $request->include_hotel ?? true,
            'selected_place_ids' => $request->selected_place_ids,
            'hotel_budget' => $hotelCost,
            'flight_budget' => $flightBudget,
            'activities_budget' => $activitiesBudget,
            'misc_budget' => $miscBudget,
        ]);

        // Return JSON for AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'hotel_cost' => round($hotelCost),
                'places_cost' => round($placesCost),
                'flight_budget' => round($flightBudget),
                'misc_budget' => round($miscBudget),
                'activities_budget' => round($activitiesBudget),
            ]);
        }

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Selections updated!');
    }

    public function pay($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'paid']);
            return redirect()->route('bookings.show', $booking->id)->with('success', 'Paiement simulé avec succès. Voyage confirmé !');
        }

        return redirect()->route('bookings.show', $booking->id)->with('error', 'Ce voyage est déjà payé.');
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        if ($booking->status === 'pending') {
            $booking->delete();
            return redirect()->route('bookings.index')->with('success', 'Voyage en attente supprimé.');
        }

        return redirect()->route('bookings.index')->with('error', 'Impossible de supprimer un voyage payé.');
    }
}
