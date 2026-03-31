<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
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
            'budget' => 'required|numeric|min:100',
            'duration' => 'required|integer|min:1',
            'passengers' => 'required|integer|min:1',
        ]);

        $budgetTotal = $request->budget;
        $flightBudget = $budgetTotal * 0.30;
        $hotelBudget = $budgetTotal * 0.40;
        $activitiesBudget = $budgetTotal * 0.20;
        $miscBudget = $budgetTotal * 0.10;

        $country = Country::where('trip_type', $request->trip_type)->inRandomOrder()->first();

        if (!$country) {
            return back()->with('error', 'Aucun pays trouvé pour ce type de voyage.');
        }

        $budgetPerNight = $hotelBudget / $request->duration / $request->passengers;

        $hotel = Hotel::where('country_id', $country->id)
            ->orderByRaw("ABS(price_per_night - ?)", [$budgetPerNight])
            ->first();

        if (!$hotel) {
            return back()->with('error', 'Aucun hôtel trouvé dans ce pays.');
        }

        $totalHotelPrice = $hotel->price_per_night * $request->duration * $request->passengers;
        $totalPrice = $totalHotelPrice + $flightBudget;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'country_id' => $country->id,
            'hotel_id' => $hotel->id,
            'trip_type' => $request->trip_type,
            'budget_total' => $budgetTotal,
            'duration' => $request->duration,
            'passengers' => $request->passengers,
            'flight_budget' => $flightBudget,
            'hotel_budget' => $totalHotelPrice, // using actual hotel price for the budget calculation in breakdown
            'activities_budget' => $activitiesBudget,
            'misc_budget' => $miscBudget,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Voyage généré avec succès !');
    }
}
