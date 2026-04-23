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
        $booking = Booking::with(['city.country', 'city.places', 'hotel.city', 'departureCity'])->where('user_id', auth()->id())->findOrFail($id);
        
        $flightDurationData = $this->calculateFlightData($booking);
        $durationMinutes = $flightDurationData['minutes_total'];
        $durationStr = $flightDurationData['duration_str'];
        
        // Mock airlines with real duration-based pricing
        $airlines = ['Air Nomado', 'SkyLink Express', 'Global Jet', 'TravelAir'];
        $flights = [];
        
        foreach($airlines as $index => $airline) {
            // Base price: ~0.50 EUR per minute of flight (can vary slightly per airline)
            $basePrice = $durationMinutes * (0.45 + ($index * 0.05));
            
            $flights[] = [
                'airline' => $airline,
                'duration' => $durationStr,
                'base_price' => round($basePrice, 2),
                'classes' => [
                    'economy' => ['label' => 'Economy', 'multiplier' => 0.8, 'price' => round($basePrice * 0.8, 2)],
                    'business' => ['label' => 'Business', 'multiplier' => 1.6, 'price' => round($basePrice * 1.6, 2)],
                    'first' => ['label' => 'First Class', 'multiplier' => 1.2, 'price' => round($basePrice * 1.2, 2)],
                ]
            ];
        }

        return view('bookings.show', compact('booking', 'flights'));
    }

    private function calculateFlightData(Booking $booking)
    {
        $destinationCity = $booking->city;
        $departureCity = $booking->departureCity ?? \App\Models\City::find($booking->departure_city_id);

        if (!$destinationCity || !$destinationCity->country || !$departureCity || !$departureCity->country) {
            return ['minutes_total' => 120, 'duration_str' => '2h 0m'];
        }

        $fromCoordinates = $destinationCity->country->cardinals;
        $toCoordinates = $departureCity->country->cardinals;

        if (!$fromCoordinates || !$toCoordinates) {
            return ['minutes_total' => 120, 'duration_str' => '2h 0m'];
        }

        $distanceKm = $this->haversineDistance($toCoordinates, $fromCoordinates);
        $averageFlightSpeed = 850; // km/h
        $flightHours = ($distanceKm / $averageFlightSpeed) + 0.5; // +30 mins for takeoff/landing

        $totalMinutes = round($flightHours * 60);
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return [
            'minutes_total' => $totalMinutes,
            'duration_str' => sprintf("%dh %dm", $hours, $minutes)
        ];
    }

    private function haversineDistance(string $from, string $to): float
    {
        [$lat1, $lng1] = array_map('floatval', explode(',', $from));
        [$lat2, $lng2] = array_map('floatval', explode(',', $to));

        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->status !== 'pending') {
            return response()->json(['error' => 'Cannot modify paid bookings'], 403);
        }

        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'include_hotel' => 'nullable|boolean',
            'selected_place_ids' => 'nullable|string',
            'airline' => 'nullable|string',
            'flight_duration' => 'nullable|string',
            'flight_class' => 'nullable|string',
            'flight_price' => 'nullable|numeric',
        ]);

        // Recalculate budgets based on selections
        $hotel = Hotel::findOrFail($request->hotel_id);
        $hotelCost = $request->include_hotel
            ? ($hotel->price_per_night * $booking->duration * $booking->passengers)
            : 0;

        $flightCost = ($request->flight_price ?? 0) * $booking->passengers;

        $placeIds = array_filter(explode(',', $request->selected_place_ids ?? ''));
        $places = Place::whereIn('id', $placeIds)->get();
        $placesCost = $places->sum(fn($p) => $p->min_price * $booking->passengers);

        $remaining = $booking->budget_total - $hotelCost - $flightCost;
        
        // Simple budget redistribution
        $miscBudget = $remaining * 0.20;
        $activitiesBudget = $remaining * 0.80;

        // Update booking
        $booking->update([
            'hotel_id' => $request->hotel_id,
            'include_hotel' => $request->include_hotel ?? true,
            'selected_place_ids' => $request->selected_place_ids,
            'flight_airline' => $request->airline,
            'flight_duration' => $request->flight_duration,
            'flight_class' => $request->flight_class,
            'flight_price' => $request->flight_price,
            'hotel_budget' => $hotelCost,
            'flight_budget' => $flightCost,
            'activities_budget' => $activitiesBudget,
            'misc_budget' => $miscBudget,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'hotel_cost' => round($hotelCost),
                'places_cost' => round($placesCost),
                'flight_budget' => round($flightCost),
                'misc_budget' => round($miscBudget),
                'activities_budget' => round($activitiesBudget),
            ]);
        }

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Journey updated!');
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
