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
        $duration = $booking->duration;
        $flightDuration = $this->calculateFlightDuration($booking);

        // Get places sorted by price
        $places = $destinationCity->places->sortBy('min_price')->values();

        // Get selected place IDs
        $selectedPlaceIds = [];
        if ($booking->selected_place_ids) {
            $selectedPlaceIds = array_map('intval', explode(',', $booking->selected_place_ids));
            $places = $places->filter(fn($p) => in_array($p->id, $selectedPlaceIds));
        }

        $plan = [];

        $departureCityName = $departureCity ? $departureCity->name : 'home';
        $departureCountry = $departureCity && $departureCity->country ? $departureCity->country->name : '';

        // Day 1: Travel Day
        $plan[] = [
            'day' => 1,
            'icon' => '✈️',
            'title' => "Flight to {$destinationCity->name}",
            'description' => "Departure from {$departureCityName}" . ($departureCountry ? ", {$departureCountry}" : "") . " — Flight duration: {$flightDuration}",
            'type' => 'travel',
            'color' => 'blue',
        ];

        if ($duration <= 1) {
            // If only 1 day, add last day right after
            $plan[] = [
                'day' => $duration,
                'icon' => '🛬',
                'title' => "Return Flight",
                'description' => "Flight back to {$departureCityName} — Flight duration: {$flightDuration}",
                'type' => 'travel',
                'color' => 'blue',
            ];
            return $plan;
        }

        // Day 2: Hotel check-in
        if ($booking->include_hotel && $booking->hotel) {
            $plan[] = [
                'day' => 2,
                'icon' => '🏨',
                'title' => "Check-in at {$booking->hotel->name}",
                'description' => "Rest & settle in. Explore the local neighborhood.",
                'type' => 'hotel',
                'color' => 'amber',
            ];
        }

        // Days 3 to duration-1: Places and free exploration
        $dayCounter = $booking->include_hotel && $booking->hotel ? 3 : 2;
        $placeIndex = 0;

        while ($dayCounter < $duration && $placeIndex < count($places)) {
            $placesPerDay = 2;  // Try to fit 2 places per day
            $dayPlaces = [];

            for ($i = 0; $i < $placesPerDay && $placeIndex < count($places); $i++) {
                $dayPlaces[] = $places[$placeIndex];
                $placeIndex++;
            }

            if (count($dayPlaces) > 0) {
                $place = $dayPlaces[0];
                $descSnippet = substr($place->description, 0, 100);
                if (strlen($place->description) > 100) {
                    $descSnippet .= '...';
                }

                $plan[] = [
                    'day' => $dayCounter,
                    'icon' => '📍',
                    'title' => $place->name,
                    'description' => "{$descSnippet} — From €{$place->min_price}",
                    'type' => 'place',
                    'color' => 'emerald',
                ];

                // If 2 places per day, add second place to same day description
                if (count($dayPlaces) > 1) {
                    $place2 = $dayPlaces[1];
                    $descSnippet2 = substr($place2->description, 0, 60);
                    if (strlen($place2->description) > 60) {
                        $descSnippet2 .= '...';
                    }
                    $plan[count($plan) - 1]['description'] .= " & {$place2->name} — €{$place2->min_price}";
                }
            } else {
                // Free exploration day
                $plan[] = [
                    'day' => $dayCounter,
                    'icon' => '🗺️',
                    'title' => "Free Exploration",
                    'description' => "Discover hidden gems in {$destinationCity->name}",
                    'type' => 'free',
                    'color' => 'slate',
                ];
            }

            $dayCounter++;
        }

        // Fill remaining days with free exploration
        while ($dayCounter < $duration) {
            $plan[] = [
                'day' => $dayCounter,
                'icon' => '🗺️',
                'title' => "Free Exploration",
                'description' => "Discover hidden gems in {$destinationCity->name}",
                'type' => 'free',
                'color' => 'slate',
            ];
            $dayCounter++;
        }

        // Last day: Return Home
        $plan[] = [
            'day' => $duration,
            'icon' => '🛬',
            'title' => "Return Flight",
            'description' => "Flight back to {$departureCityName}" . ($departureCountry ? ", {$departureCountry}" : "") . " — Flight duration: {$flightDuration}",
            'type' => 'travel',
            'color' => 'blue',
        ];

        return $plan;
    }
}


