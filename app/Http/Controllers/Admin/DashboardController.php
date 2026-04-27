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
        $user = auth()->user();
        $stats = [
            'total_countries' => Country::count(),
            'total_cities' => City::count(),
            'total_hotels' => Hotel::count(),
            'total_places' => Place::count(),
        ];

        if ($user->isAdmin()) {
            $stats['total_users'] = User::count();
            $stats['total_bookings'] = Booking::count();
            $stats['total_revenue'] = Booking::where('status', 'paid')->sum('budget_total');
            
            $latest_bookings = Booking::with(['user', 'city'])->latest()->take(5)->get();
            $recent_users = User::latest()->take(5)->get();
        } else {
            $latest_bookings = collect();
            $recent_users = collect();
        }

        return view('admin.dashboard', compact('stats', 'latest_bookings', 'recent_users'));
    }
}
