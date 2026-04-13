<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Hotel;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class TripGeneratorController extends Controller
{
    public function index()
    {
        return view('trip.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'trip_type' => 'required|in:adventure,culture,beach,romantic,nature,shopping',
            'budget'    => 'required|numeric|min:100',
            'duration'  => 'required|integer|min:1',
            'passengers' => 'required|integer|min:1',
        ]);

        $budgetTotal       = $request->budget;
        $flightBudget      = $budgetTotal * 0.30;
        $hotelBudget       = $budgetTotal * 0.40;
        $activitiesBudget  = $budgetTotal * 0.20;
        $miscBudget        = $budgetTotal * 0.10;

        $place = Place::where('trip_type', $request->trip_type)->inRandomOrder()->first();

        if (!$place) {
            return back()->with('error', 'Aucun lieu trouvé pour ce type de voyage.');
        }

        $budgetPerNight = $hotelBudget / $request->duration / $request->passengers;

        $hotel = Hotel::where('place_id', $place->id)
            ->orderByRaw('ABS(price_per_night - ?)', [$budgetPerNight])
            ->first();

        if (!$hotel) {
            return back()->with('error', 'Aucun hôtel trouvé pour ce lieu.');
        }

        $totalHotelPrice = $hotel->price_per_night * $request->duration * $request->passengers;
        $totalPrice      = $totalHotelPrice + $flightBudget;

        $booking = Booking::create([
            'user_id'           => Auth::id(),
            'place_id'          => $place->id,
            'hotel_id'          => $hotel->id,
            'trip_type'         => $request->trip_type,
            'budget_total'      => $budgetTotal,
            'duration'          => $request->duration,
            'passengers'        => $request->passengers,
            'flight_budget'     => $flightBudget,
            'hotel_budget'      => $totalHotelPrice,
            'activities_budget' => $activitiesBudget,
            'misc_budget'       => $miscBudget,
            'total_price'       => $totalPrice,
            'status'            => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Voyage généré avec succès !');
    }
}
