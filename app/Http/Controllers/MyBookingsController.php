<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class MyBookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['city.country', 'hotel'])->where('user_id', auth()->id())->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['city.country', 'city.places', 'hotel.city'])->where('user_id', auth()->id())->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function pay($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'paid']);
            return redirect()->route('bookings.show', $booking->id)->with('success', 'Paiement simulé avec succès. Voyage confirmé !');
        }

        return redirect()->route('bookings.show', $booking->id)->with('error', 'Ce voyage est déjà payé.');
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        if ($booking->status === 'pending') {
            $booking->delete();
            return redirect()->route('bookings.index')->with('success', 'Voyage en attente supprimé.');
        }

        return redirect()->route('bookings.index')->with('error', 'Impossible de supprimer un voyage payé.');
    }
}
