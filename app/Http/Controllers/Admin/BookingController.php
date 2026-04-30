<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'city.country', 'hotels'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }
}
