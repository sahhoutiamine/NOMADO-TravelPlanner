<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\City;
use Illuminate\Http\Request;

class TripPlanController extends Controller
{
    public function show($bookingId)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($bookingId);
        $plan = $this->generatePlan($booking);
        $flightDuration = $this->calculateFlightDuration($booking);

        return view('bookings.plan', compact('booking', 'plan', 'flightDuration'));
    }

    private function haversineDistance(string $from, string $to): float
    {
        [$lat1, $lng1] = array_map('floatval', explode(',', $from));
        [$lat2, $lng2] = array_map('floatval', explode(',', $to));

        $R = 6371; // Earth radius in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }

    private function calculateFlightDuration(Booking $booking): string
    {
        if (!empty($booking->flight_duration)) {
            return $booking->flight_duration;
        }

        $destinationCity = $booking->city;
        $departureCity = $booking->departureCity ?? City::find($booking->departure_city_id);

        if (!$destinationCity || !$destinationCity->country || !$departureCity || !$departureCity->country) {
            return "N/A";
        }

        $fromCoordinates = $destinationCity->country->cardinals;
        $toCoordinates = $departureCity->country->cardinals;

        if (!$fromCoordinates || !$toCoordinates) {
            return "N/A";
        }

        $distanceKm = $this->haversineDistance($toCoordinates, $fromCoordinates);
        $averageFlightSpeed = 900; // km/h
        $flightHours = $distanceKm / $averageFlightSpeed;

        $hours = floor($flightHours);
        $minutes = round(($flightHours - $hours) * 60);

        return sprintf("%dh %dm", $hours, $minutes);
    }

    private function generatePlan(Booking $booking): array
    {
        $destinationCity = $booking->city;
        $departureCity = $booking->departureCity ?? City::find($booking->departure_city_id);
        $duration = $booking->duration; // User's total duration (e.g. 7)
        $flightDuration = $this->calculateFlightDuration($booking);

        // Get places sorted by price
        $places = $destinationCity->places->sortBy('min_price')->values();

        // Get selected place IDs - only show what user chose
        if ($booking->selected_place_ids) {
            $selectedPlaceIds = array_map('intval', explode(',', $booking->selected_place_ids));
            $places = $places->filter(fn($p) => in_array($p->id, $selectedPlaceIds))->values();
        } else {
            $places = collect();
        }

        $plan = [];
        $departureCityName = $departureCity ? $departureCity->name : 'home';
        $departureCountry = $departureCity && $departureCity->country ? $departureCity->country->name : '';

        // Day 1: Arrival & Welcome
        $hotelInfo = "";
        if ($booking->include_hotel && $booking->hotel) {
            $hotelInfo = ". Upon arrival in {$destinationCity->name}, check-in at {$booking->hotel->name} and relax after your journey";
        } else {
            $hotelInfo = ". Upon arrival, take some time to settle in and explore your surroundings";
        }

        $plan[] = [
            'day' => 1,
            'icon' => 'flight_land',
            'title' => "Travel Day & Welcome",
            'description' => "Flight from {$departureCityName}" . ($departureCountry ? ", {$departureCountry}" : "") . " ({$flightDuration}){$hotelInfo}.",
            'type' => 'travel',
            'color' => 'blue',
        ];

        if ($duration > 1) {
            $activityDays = $duration - 2; // Middle days
            $placeIndex = 0;
            $totalPlaces = count($places);
            
            // Calculate how many places per day to ensure ALL are shown
            $placesPerDay = $activityDays > 0 ? ceil($totalPlaces / $activityDays) : $totalPlaces;
            $placesPerDay = max(1, $placesPerDay);

            // Fill activity days
            for ($d = 1; $d <= max(0, $activityDays); $d++) {
                $currentDay = $d + 1;
                $dayPlaces = [];

                for ($i = 0; $i < $placesPerDay && $placeIndex < $totalPlaces; $i++) {
                    $dayPlaces[] = $places[$placeIndex];
                    $placeIndex++;
                }

                if (count($dayPlaces) > 0) {
                    $titles = [];
                    $descriptions = [];
                    foreach ($dayPlaces as $p) {
                        $titles[] = $p->name;
                        $descSnippet = substr($p->description, 0, 100);
                        if (strlen($p->description) > 100) $descSnippet .= '...';
                        $descriptions[] = "{$p->name}: {$descSnippet} (€{$p->min_price})";
                    }

                    $plan[] = [
                        'day' => $currentDay,
                        'icon' => 'location_on',
                        'title' => implode(' & ', $titles),
                        'description' => implode(' ', $descriptions),
                        'type' => 'place',
                        'color' => 'emerald',
                    ];
                } else {
                    // Free exploration day
                    $plan[] = [
                        'day' => $currentDay,
                        'icon' => 'explore',
                        'title' => "Free Exploration in {$destinationCity->name}",
                        'description' => "Take this day to discover hidden gems, visit local markets, or simply soak in the atmosphere of the city at your own pace.",
                        'type' => 'free',
                        'color' => 'slate',
                    ];
                }
            }

            // If there are still places left (e.g. duration is small), add them to the last activity day or arrival
            if ($placeIndex < $totalPlaces && count($plan) > 0) {
                $remainingPlaces = $places->slice($placeIndex);
                $extraDesc = [];
                foreach ($remainingPlaces as $p) {
                    $extraDesc[] = "{$p->name} (€{$p->min_price})";
                }
                $plan[count($plan)-1]['description'] .= " Also consider visiting: " . implode(', ', $extraDesc) . ".";
            }

            // Last Day: Return Home (only if duration > 1)
            $plan[] = [
                'day' => $duration,
                'icon' => 'flight_takeoff',
                'title' => "Final Day & Departure",
                'description' => "Enjoy your last breakfast in {$destinationCity->name}, complete your souvenir shopping, and head to the airport for your return flight to {$departureCityName} ({$flightDuration}).",
                'type' => 'travel',
                'color' => 'blue',
            ];
        }

        return $plan;
    }
}


