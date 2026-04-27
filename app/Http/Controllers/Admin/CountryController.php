<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle file upload - takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('countries', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        unset($validated['image_file']);
        Country::create($validated);
        return redirect()->route('admin.countries.index')->with('success', 'Pays ajouté.');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle file upload - takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('countries', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        unset($validated['image_file']);
        $country->update($validated);
        return redirect()->route('admin.countries.index')->with('success', 'Pays modifié.');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('admin.countries.index')->with('success', 'Pays supprimé.');
    }
}
