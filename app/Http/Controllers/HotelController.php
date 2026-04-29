<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class HotelController extends Controller
{
    public function show(int $id)
    {
        $hotel = Hotel::with(['city.country'])->findOrFail($id);

        return view('hotels.show', compact('hotel'));
    }
}
