<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('country')->get();
        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('admin.cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'trip_type' => 'required|in:adventure,culture,beach,romantic,nature,shopping',
        ]);

        // Handle file upload - takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('cities', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        unset($validated['image_file']);
        City::create($validated);
        return redirect()->route('admin.cities.index')->with('success', 'Ville ajoutée avec succès.');
    }

    public function edit(City $city)
    {
        $countries = Country::all();
        return view('admin.cities.edit', compact('city', 'countries'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'trip_type' => 'required|in:adventure,culture,beach,romantic,nature,shopping',
        ]);

        // Handle file upload - takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('cities', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        unset($validated['image_file']);
        $city->update($validated);
        return redirect()->route('admin.cities.index')->with('success', 'Ville modifiée avec succès.');
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'Ville supprimée.');
    }
}
