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
        $userId = auth()->id();
        $bookings = Booking::with(['city.country', 'hotels'])
            ->where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhereHas('participants', function($q) use ($userId) {
                          $q->where('user_id', $userId);
                      });
            })
            ->latest()
            ->get();
            
        return view('bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $userId = auth()->id();
        $booking = Booking::with(['city.country', 'city.places', 'hotels.city', 'departureCity', 'places'])
            ->where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhereHas('participants', function($q) use ($userId) {
                          $q->where('user_id', $userId);
                      });
            })
            ->findOrFail($id);
        
        $flightDurationData = $this->calculateFlightData($booking);
        $durationMinutes = $flightDurationData['minutes_total'];
        $durationStr = $flightDurationData['duration_str'];
        
        // Real airlines with realistic duration-based pricing
        $airlineNames = ['Emirates', 'Qatar Airways', 'Lufthansa', 'Air France', 'British Airways'];
        $flights = [];
        
        $startCity = $booking->departureCity->name ?? 'Home';
        $endCity = $booking->city->name;

        foreach($airlineNames as $index => $airline) {
            // Realistic pricing: ~0.85 EUR per minute + fixed base fee
            // Short haul (2h) -> ~150-200 EUR
            // Long haul (10h) -> ~600-800 EUR
            $basePrice = (100 + ($durationMinutes * 0.85)) * (1 + ($index * 0.05));
            
            $flights[] = [
                'airline' => $airline,
                'duration' => $durationStr,
                'start_city' => $startCity,
                'end_city' => $endCity,
                'base_price' => round($basePrice, 2),
                'classes' => [
                    'economy' => ['label' => 'Economy', 'multiplier' => 0.8, 'price' => round($basePrice * 0.8, 2)],
                    'business' => ['label' => 'Business', 'multiplier' => 1.6, 'price' => round($basePrice * 1.6, 2)],
                    'first' => ['label' => 'First Class', 'multiplier' => 2.4, 'price' => round($basePrice * 2.4, 2)],
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
        try {
            $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

            if ($booking->status !== 'pending') {
                return response()->json(['success' => false, 'error' => 'Cannot modify paid bookings'], 403);
            }

            $request->validate([
                'selected_hotels' => 'nullable|string',
                'include_hotel' => 'nullable|boolean',
                'selected_place_ids' => 'nullable|string',
                'airline' => 'nullable|string',
                'flight_duration' => 'nullable|string',
                'flight_class' => 'nullable|string',
                'flight_budget' => 'nullable|numeric',
                'budget_total' => 'nullable|numeric',
            ]);

            if ($request->budget_total && $request->budget_total > $booking->budget_total) {
                $booking->budget_total = $request->budget_total;
            }

            // Recalculate hotel cost from JSON
            $hotelCost = 0;
            $hotelSyncData = [];
            if ($request->has('selected_hotels') && ($request->include_hotel ?? true)) {
                $hotelData = json_decode($request->selected_hotels, true);
                if (is_array($hotelData)) {
                    foreach ($hotelData as $h) {
                        $hotel = Hotel::find($h['id']);
                        if ($hotel && !empty($h['check_in']) && !empty($h['check_out'])) {
                            $checkIn = \Carbon\Carbon::parse($h['check_in']);
                            $checkOut = \Carbon\Carbon::parse($h['check_out']);
                            $nights = max(1, $checkIn->diffInDays($checkOut));
                            $hotelCost += $hotel->price_per_night * $nights * $booking->passengers;
                            $hotelSyncData[$h['id']] = [
                                'check_in_date' => $h['check_in'],
                                'check_out_date' => $h['check_out']
                            ];
                        }
                    }
                }
            }

            $flightCost = ($request->flight_budget ?? 0) * $booking->passengers;

            $placeIds = array_filter(explode(',', $request->selected_place_ids ?? ''));
            $places = Place::whereIn('id', $placeIds)->get();
            $placesCost = $places->sum(fn($p) => $p->min_price * $booking->passengers);

            $remaining = $booking->budget_total - $hotelCost - $flightCost;
            
            // Simple budget redistribution
            $miscBudget = $remaining * 0.20;
            $activitiesBudget = $remaining * 0.80;

            // Update booking
            $booking->update([
                'budget_total' => $booking->budget_total,
                'include_hotel' => $request->include_hotel ?? true,
                'selected_place_ids' => $request->selected_place_ids,
                'flight_airline' => $request->airline,
                'flight_duration' => $request->flight_duration,
                'flight_class' => $request->flight_class,
                'hotel_budget' => $hotelCost,
                'flight_budget' => $flightCost,
                'activities_budget' => $activitiesBudget,
                'misc_budget' => $miscBudget,
            ]);

            // Sync hotels
            if (!empty($hotelSyncData)) {
                $booking->hotels()->sync($hotelSyncData);
            } else if (!$request->include_hotel) {
                $booking->hotels()->detach();
            }

            // Sync places with dates
            if ($request->has('place_dates')) {
                $placeData = json_decode($request->place_dates, true);
                $syncData = [];
                
                $minVisitDate = $booking->departure_date ? $booking->departure_date->copy()->addDays(2) : null;

                if (is_array($placeData)) {
                    foreach ($placeData as $placeId => $date) {
                        if ($date && $minVisitDate && \Carbon\Carbon::parse($date)->lt($minVisitDate)) {
                            $date = $minVisitDate->format('Y-m-d'); // Force to minimum allowed date
                        }
                        $syncData[$placeId] = ['visit_date' => $date ?: null];
                    }
                }
                
                $booking->places()->sync($syncData);
            } else if ($request->has('selected_place_ids')) {
                // Fallback if place_dates is not sent but selected_place_ids is
                $placeIds = array_filter(explode(',', $request->selected_place_ids));
                $booking->places()->sync($placeIds);
            }

            return response()->json([
                'success' => true,
                'hotel_cost' => round($hotelCost),
                'places_cost' => round($placesCost),
                'flight_budget' => round($flightCost),
                'misc_budget' => round($miscBudget),
                'activities_budget' => round($activitiesBudget),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
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

    public function shareCode($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        if ($booking->passengers <= 1) {
            return response()->json(['success' => false, 'error' => 'Only multi-passenger trips can be shared.'], 403);
        }

        if (!$booking->share_code) {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
            // Ensure uniqueness
            while (Booking::where('share_code', $code)->exists()) {
                $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
            }
            $booking->update(['share_code' => $code]);
        }

        return response()->json(['success' => true, 'code' => $booking->share_code]);
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $booking = Booking::where('share_code', strtoupper($request->code))->first();

        if (!$booking) {
            return back()->with('error', 'Invalid share code.');
        }

        if ($booking->user_id === auth()->id()) {
            return back()->with('error', 'You are already the owner of this trip.');
        }

        if ($booking->participants()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already joined this trip.');
        }

        $booking->participants()->attach(auth()->id(), ['isOwner' => false]);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'You have successfully joined the trip!');
    }
}
