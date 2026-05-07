<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Place;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // Create 2-3 bookings for each user
            Booking::factory(rand(2, 3))->create()->each(function ($booking) use ($user) {
                // Attach user as owner
                $booking->participants()->attach($user->id, ['isOwner' => true]);

                // Attach some random hotels (if available)
                $hotels = Hotel::inRandomOrder()->limit(rand(1, 2))->get();
                foreach ($hotels as $hotel) {
                    $booking->hotels()->attach($hotel->id, [
                        'check_in_date' => $booking->departure_date,
                        'check_out_date' => $booking->departure_date->copy()->addDays($booking->duration),
                    ]);
                }

                // Attach some random places (if available)
                $places = Place::inRandomOrder()->limit(rand(3, 5))->get();
                foreach ($places as $place) {
                    $booking->places()->attach($place->id, [
                        'visit_date' => $booking->departure_date->copy()->addDays(rand(0, $booking->duration)),
                    ]);
                }
            });
        }
    }
}
