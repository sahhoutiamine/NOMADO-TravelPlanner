<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripGeneratorController;
use App\Http\Controllers\MyBookingsController;
use App\Http\Controllers\HotelShowController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\HotelController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if(auth()->user()->role === 'admin') {
            return redirect()->route('admin.bookings.index');
        }
        return redirect()->route('trip.index');
    })->name('dashboard');

    // User Routes
    Route::get('/generate', [TripGeneratorController::class, 'index'])->name('trip.index');
    Route::post('/generate', [TripGeneratorController::class, 'generate'])->name('trip.generate');
    Route::post('/trip/confirm', [TripGeneratorController::class, 'confirm'])->name('trip.confirm');

    Route::get('/my-bookings', [MyBookingsController::class, 'index'])->name('bookings.index');
    Route::get('/my-bookings/{id}', [MyBookingsController::class, 'show'])->name('bookings.show');
    Route::post('/my-bookings/{id}/pay', [MyBookingsController::class, 'pay'])->name('bookings.pay');
    Route::delete('/my-bookings/{id}', [MyBookingsController::class, 'destroy'])->name('bookings.destroy');

    // Place Explorer Routes
    Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
    Route::get('/places/{id}', [PlaceController::class, 'show'])->name('places.show');

    // Hotel Detail Route
    Route::get('/hotels/{id}', [HotelShowController::class, 'show'])->name('hotels.show');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('countries', CountryController::class);
    Route::resource('hotels', HotelController::class);
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
});

require __DIR__.'/auth.php';
