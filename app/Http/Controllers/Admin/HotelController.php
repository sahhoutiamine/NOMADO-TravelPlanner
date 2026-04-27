<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\City;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('city.country')->get();
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $cities = City::with('country')->get();
        return view('admin.hotels.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:economy,mid_range,luxury',
        ]);

        // Handle file upload - takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('hotels', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        unset($validated['image_file']);
        Hotel::create($validated);
        return redirect()->route('admin.hotels.index')->with('success', 'Hôtel ajouté.');
    }

    public function edit(Hotel $hotel)
    {
        $cities = City::with('country')->get();
        return view('admin.hotels.edit', compact('hotel', 'cities'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'type' => 'required|in:economy,mid_range,luxury',
        ]);

        // Handle file upload - takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('hotels', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        unset($validated['image_file']);
        $hotel->update($validated);
        return redirect()->route('admin.hotels.index')->with('success', 'Hôtel modifié.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('admin.hotels.index')->with('success', 'Hôtel supprimé.');
    }
}
