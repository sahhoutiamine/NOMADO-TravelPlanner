<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('hotels')->truncate();
        Schema::enableForeignKeyConstraints();

        $places = \App\Models\Place::all();
        $now = Carbon::now();

        $hotelImages = [
            'https://images.unsplash.com/photo-1566073771259-6a8506099945',
            'https://images.unsplash.com/photo-1551882547-ff40c0d125fa',
            'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9',
            'https://images.unsplash.com/photo-1542314831-c6a4d27ce6a2',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd',
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4',
            'https://images.unsplash.com/photo-1517840901100-8179e982acb7',
            'https://images.unsplash.com/photo-1555854877-bab0e564b8d5',
            'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd',
            'https://images.unsplash.com/photo-1611892440504-42a792e24d32',
        ];

        // Hotel naming patterns based on place type/rating
        $hotelTypes = [
            'Luxury' => ['Grand', 'Royal', 'Palace', 'Plaza', 'Continental'],
            'Mid-Range' => ['Garden', 'Central', 'Plaza', 'Inn', 'Suites'],
            'Budget' => ['Lodge', 'Hostel', 'Inn', 'Guest House', 'Stay']
        ];

        $insertData = [];

        foreach ($places as $place) {
            // Determine price based on place rating
            $pricePerNight = match(true) {
                $place->rating >= 4.7 => rand(200, 500),   // Luxury
                $place->rating >= 4.3 => rand(100, 199),   // Mid-Range
                default => rand(50, 99)                     // Budget
            };
            
            // Select appropriate hotel type
            $type = match(true) {
                $pricePerNight >= 200 => 'Luxury',
                $pricePerNight >= 100 => 'Mid-Range',
                default => 'Budget'
            };
            
            $namePrefix = $hotelTypes[$type][array_rand($hotelTypes[$type])];
            $hotelName = $namePrefix . ' ' . $place->name;
            
            // Ensure name isn't too long
            if (strlen($hotelName) > 60) {
                $hotelName = $namePrefix . ' ' . explode(' ', $place->name)[0];
            }

            $image = $hotelImages[array_rand($hotelImages)] . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
            
            $adjectives = ['beautiful', 'stunning', 'vibrant', 'peaceful', 'magnificent', 'charming', 'luxurious', 'cozy'];
            $adj = $adjectives[array_rand($adjectives)];

            $insertData[] = [
                'place_id' => $place->id,
                'name' => $hotelName,
                'location' => $place->city,
                'price_per_night' => $pricePerNight,
                'description' => "Experience a {$adj} stay at {$hotelName}, perfectly situated near {$place->name} in {$place->city}. " . 
                                "This " . strtolower($type) . " accommodation offers exceptional comfort and convenient access to local attractions.",
                'image' => $image,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert in chunks
        $chunks = array_chunk($insertData, 50);
        foreach ($chunks as $chunk) {
            DB::table('hotels')->insert($chunk);
        }
    }
}