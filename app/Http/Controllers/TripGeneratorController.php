<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class TripGeneratorController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('name')->get();
        return view('trip.index', compact('cities'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'trip_type' => 'required|in:adventure,culture,beach,romantic,nature,shopping',
            'budget'    => 'required|numeric|min:100',
            'duration'  => 'required|integer|min:1',
            'passengers' => 'required|integer|min:1',
            'departure_city_id' => 'required|exists:cities,id',
        ]);

        $budgetTotal = $request->budget;
        $trip_type = $request->trip_type;
        $duration = $request->duration;
        $passengers = $request->passengers;
        $departure_city_id = $request->departure_city_id;

        // Find cities matching trip type (excluding departure city)
        $cities = City::where('trip_type', $trip_type)
            ->where('id', '!=', $departure_city_id)
            ->get();

        if ($cities->isEmpty()) {
            return back()->with('error', 'Aucune ville trouvée pour ce type de voyage.');
        }

        // Search for hotels that fit within ~70% of the total budget to leave room for activities
        $maxHotelTotal = $budgetTotal * 0.7;
        $maxPricePerNight = $maxHotelTotal / $duration / $passengers;

        $hotels = Hotel::with('city.places')
            ->whereIn('city_id', $cities->pluck('id'))
            ->where('price_per_night', '<=', $maxPricePerNight)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        if ($hotels->isEmpty()) {
            // Fallback: search for any hotel within the budget in these cities
            $maxPricePerNight = $budgetTotal / $duration / $passengers;
            $hotels = Hotel::with('city.places')
                ->whereIn('city_id', $cities->pluck('id'))
                ->where('price_per_night', '<=', $maxPricePerNight)
                ->orderBy('price_per_night', 'asc')
                ->limit(3)
                ->get();
        }

        if ($hotels->isEmpty()) {
            return back()->with('error', 'Aucun voyage trouvé correspondant à votre budget.');
        }

        $trips = [];
        foreach ($hotels as $hotel) {
            $hotelTotal = $hotel->price_per_night * $duration * $passengers;
            $remaining = $budgetTotal - $hotelTotal;

            $trips[] = [
                'city' => $hotel->city,
                'hotel' => $hotel,
                'duration' => $duration,
                'passengers' => $passengers,
                'flight_budget' => 0,
                'hotel_budget' => $hotelTotal,
                'activities_budget' => $remaining * 0.7,
                'misc_budget' => $remaining * 0.3,
                'budget_total' => $budgetTotal,
                'trip_type' => $trip_type
            ];
        }

        return view('results', compact('trips', 'budgetTotal', 'departure_city_id'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'hotel_id' => 'required|exists:hotels,id',
            'duration' => 'required|integer',
            'passengers' => 'required|integer',
            'budget_total' => 'required|numeric',
            'flight_budget' => 'required|numeric',
            'hotel_budget' => 'required|numeric',
            'activities_budget' => 'required|numeric',
            'misc_budget' => 'required|numeric',
            'trip_type' => 'required',
            'departure_city_id' => 'required|exists:cities,id',
            'selected_place_ids' => 'nullable|string',
            'include_hotel' => 'nullable|boolean',
        ]);

        $booking = Booking::create([
            'user_id'           => Auth::id(),
            'city_id'           => $request->city_id,
            'hotel_id'          => $request->hotel_id,
            'trip_type'         => $request->trip_type,
            'budget_total'      => $request->budget_total,
            'duration'          => $request->duration,
            'passengers'        => $request->passengers,
            'flight_budget'     => $request->flight_budget,
            'hotel_budget'      => $request->hotel_budget,
            'activities_budget' => $request->activities_budget,
            'misc_budget'       => $request->misc_budget,
            'departure_city_id' => $request->departure_city_id,
            'selected_place_ids' => $request->selected_place_ids,
            'include_hotel'     => $request->include_hotel ?? true,
            'status'            => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Voyage enregistré avec succès !');
    }
}
