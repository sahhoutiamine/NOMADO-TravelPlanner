<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\City;
use Illuminate\Http\Request;

class TripPlanController extends Controller
{
    public function show($bookingId)
    {
        $userId = auth()->id();
        $booking = Booking::where(function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('participants', function($q) use ($userId) {
                      $q->where('user_id', $userId);
                  });
        })->with(['city', 'departureCity', 'hotels', 'places'])->findOrFail($bookingId);

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
        $duration = $booking->duration;
        $flightDuration = $this->calculateFlightDuration($booking);

        $departureCityName = $departureCity ? $departureCity->name : 'home';
        $departureCountry = $departureCity && $departureCity->country ? $departureCity->country->name : '';
        $departureDate = $booking->departure_date ? \Carbon\Carbon::parse($booking->departure_date) : now();

        // Build lookup maps from real booking data
        // Hotels keyed by date
        $hotelCheckIns = [];  // date => hotel
        $hotelCheckOuts = []; // date => hotel
        $hotelStays = [];     // date => hotel (staying at this hotel on this night)

        foreach ($booking->hotels as $hotel) {
            $checkIn = $hotel->pivot->check_in_date ? \Carbon\Carbon::parse($hotel->pivot->check_in_date) : null;
            $checkOut = $hotel->pivot->check_out_date ? \Carbon\Carbon::parse($hotel->pivot->check_out_date) : null;

            if ($checkIn) {
                $hotelCheckIns[$checkIn->format('Y-m-d')] = $hotel;
            }
            if ($checkOut) {
                $hotelCheckOuts[$checkOut->format('Y-m-d')] = $hotel;
            }
            // Mark each night of stay
            if ($checkIn && $checkOut) {
                $cursor = $checkIn->copy();
                while ($cursor->lt($checkOut)) {
                    $hotelStays[$cursor->format('Y-m-d')] = $hotel;
                    $cursor->addDay();
                }
            }
        }

        // Places keyed by visit_date
        $placesByDate = [];
        $unscheduledPlaces = [];

        foreach ($booking->places as $place) {
            $visitDate = $place->pivot->visit_date;
            if ($visitDate) {
                $key = \Carbon\Carbon::parse($visitDate)->format('Y-m-d');
                $placesByDate[$key][] = $place;
            } else {
                $unscheduledPlaces[] = $place;
            }
        }

        // Build the plan day by day
        $plan = [];

        for ($d = 0; $d < $duration; $d++) {
            $currentDate = $departureDate->copy()->addDays($d);
            $dateStr = $currentDate->format('Y-m-d');
            $dateLabel = $currentDate->format('M d, Y');
            $dayNum = $d + 1;

            // --- Day 1: Arrival ---
            if ($d === 0) {
                $hotelNote = '';
                $checkInHotel = $hotelCheckIns[$dateStr] ?? null;
                if (!$checkInHotel) {
                    // Check if there's a hotel check-in the next day
                    $nextDate = $departureDate->copy()->addDay()->format('Y-m-d');
                    $checkInHotel = $hotelCheckIns[$nextDate] ?? null;
                    if ($checkInHotel) {
                        $hotelNote = " Check-in at {$checkInHotel->name} tomorrow.";
                    }
                } else {
                    $hotelNote = " Check-in at {$checkInHotel->name}.";
                }

                $plan[] = [
                    'day' => $dayNum,
                    'date' => $dateLabel,
                    'icon' => 'flight_land',
                    'title' => "Arrival in {$destinationCity->name}",
                    'description' => "Flight from {$departureCityName}" . ($departureCountry ? ", {$departureCountry}" : "") . " ({$flightDuration}). Welcome to {$destinationCity->name}!{$hotelNote}",
                    'type' => 'travel',
                    'color' => 'blue',
                    'hotels' => [],
                    'places' => [],
                ];
                continue;
            }

            // --- Last Day: Departure ---
            if ($d === $duration - 1) {
                $checkOutHotel = $hotelCheckOuts[$dateStr] ?? null;
                $checkOutNote = $checkOutHotel ? " Check-out from {$checkOutHotel->name}." : "";

                $plan[] = [
                    'day' => $dayNum,
                    'date' => $dateLabel,
                    'icon' => 'flight_takeoff',
                    'title' => "Departure Day",
                    'description' => "Last moments in {$destinationCity->name}.{$checkOutNote} Return flight to {$departureCityName} ({$flightDuration}).",
                    'type' => 'travel',
                    'color' => 'blue',
                    'hotels' => [],
                    'places' => [],
                ];
                continue;
            }

            // --- Middle Days ---
            $dayHotels = [];
            $dayPlaces = $placesByDate[$dateStr] ?? [];

            // Hotel check-in today?
            $checkInHotel = $hotelCheckIns[$dateStr] ?? null;
            if ($checkInHotel) {
                $dayHotels[] = ['hotel' => $checkInHotel, 'action' => 'check_in'];
            }

            // Hotel check-out today?
            $checkOutHotel = $hotelCheckOuts[$dateStr] ?? null;
            if ($checkOutHotel) {
                // Put check-out before check-in
                array_unshift($dayHotels, ['hotel' => $checkOutHotel, 'action' => 'check_out']);
            }

            // Currently staying at a hotel?
            $stayingAt = $hotelStays[$dateStr] ?? null;

            // Build description
            $parts = [];

            foreach ($dayHotels as $hInfo) {
                if ($hInfo['action'] === 'check_out') {
                    $parts[] = "Check-out from {$hInfo['hotel']->name}.";
                } else {
                    $parts[] = "Check-in at {$hInfo['hotel']->name}.";
                }
            }

            if (count($dayPlaces) > 0) {
                foreach ($dayPlaces as $p) {
                    $desc = substr($p->description ?? '', 0, 80);
                    if (strlen($p->description ?? '') > 80) $desc .= '...';
                    $parts[] = "Visit {$p->name}" . ($desc ? ": {$desc}" : "") . " (€{$p->min_price}).";
                }
            }

            if (empty($parts) && $stayingAt) {
                $parts[] = "Free exploration day in {$destinationCity->name}. Enjoy your stay at {$stayingAt->name}.";
            } elseif (empty($parts)) {
                $parts[] = "Free day to explore {$destinationCity->name} at your own pace.";
            }

            // Determine type & color
            $type = 'free';
            $color = 'slate';
            $icon = 'explore';
            $title = "Day in {$destinationCity->name}";

            if (count($dayPlaces) > 0) {
                $type = 'place';
                $color = 'emerald';
                $icon = 'location_on';
                $placeNames = array_map(fn($p) => $p->name, $dayPlaces);
                $title = implode(' & ', $placeNames);
            }

            if (!empty($dayHotels)) {
                if ($type === 'free') {
                    $color = 'amber';
                    $icon = 'hotel';
                    $title = $dayHotels[0]['hotel']->name;
                }
            }

            $plan[] = [
                'day' => $dayNum,
                'date' => $dateLabel,
                'icon' => $icon,
                'title' => $title,
                'description' => implode(' ', $parts),
                'type' => $type,
                'color' => $color,
                'hotels' => $dayHotels,
                'places' => $dayPlaces,
            ];
        }

        // If there are unscheduled places, append them to the first free day
        if (!empty($unscheduledPlaces)) {
            foreach ($plan as &$day) {
                if ($day['type'] === 'free') {
                    $names = array_map(fn($p) => "{$p->name} (€{$p->min_price})", $unscheduledPlaces);
                    $day['description'] .= " Also planned: " . implode(', ', $names) . ".";
                    $day['type'] = 'place';
                    $day['color'] = 'emerald';
                    $day['icon'] = 'location_on';
                    break;
                }
            }
        }

        return $plan;
    }
}


