<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\City;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with('city')->get();
        return view('admin.places.index', compact('places'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.places.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'description' => 'required|string',
            'image' => 'nullable|string|url',
            'rating' => 'nullable|numeric|min:0|max:5',
            'localisation' => 'nullable|string',
            'trip_type' => 'required|in:adventure,culture,beach,romantic,nature,shopping'
        ]);

        Place::create($validated);
        return redirect()->route('admin.places.index')->with('success', 'Lieu ajouté avec succès.');
    }

    public function edit(Place $place)
    {
        $cities = City::all();
        return view('admin.places.edit', compact('place', 'cities'));
    }

    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'description' => 'required|string',
            'image' => 'nullable|string|url',
            'rating' => 'nullable|numeric|min:0|max:5',
            'localisation' => 'nullable|string',
            'trip_type' => 'required|in:adventure,culture,beach,romantic,nature,shopping'
        ]);

        $place->update($validated);
        return redirect()->route('admin.places.index')->with('success', 'Lieu modifié avec succès.');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('admin.places.index')->with('success', 'Lieu supprimé.');
    }
}
