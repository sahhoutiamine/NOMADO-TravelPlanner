<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Place;
use App\Models\Country;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_bookings' => Booking::count(),
            'total_revenue' => Booking::where('status', 'paid')->sum('total_price'),
            'total_countries' => Country::count(),
            'total_cities' => City::count(),
            'total_hotels' => Hotel::count(),
            'total_places' => Place::count(),
        ];

        $latest_bookings = Booking::with(['user', 'city'])->latest()->take(5)->get();
        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest_bookings', 'recent_users'));
    }
}
