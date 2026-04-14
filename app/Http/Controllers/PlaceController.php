<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Country;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $query = Place::with(['city.country', 'city.hotels']);

        if ($request->has('country_id') && $request->country_id != '') {
            $query->whereHas('city', function($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $places = $query->paginate(12);
        $countries = Country::all();

        return view('places.index', compact('places', 'countries'));
    }

    public function show($id)
    {
        $place = Place::with(['city.country', 'city.hotels'])->findOrFail($id);
        return view('places.show', compact('place'));
    }
}
