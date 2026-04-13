<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Place;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('place.country')->get();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $places = Place::with('country')->get();
        return view('admin.hotels.create', compact('places'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
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
        $places = Place::with('country')->get();
        return view('admin.hotels.edit', compact('hotel', 'places'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
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
