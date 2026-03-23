<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Country;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('country')->get();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.hotels.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url'
        ]);

        Hotel::create($validated);
        return redirect()->route('admin.hotels.index')->with('success', 'Hôtel ajouté.');
    }

    public function edit(Hotel $hotel)
    {
        $countries = Country::all();
        return view('admin.hotels.edit', compact('hotel', 'countries'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url'
        ]);

        $hotel->update($validated);
        return redirect()->route('admin.hotels.index')->with('success', 'Hôtel modifié.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hôtel supprimé.');
    }
}
