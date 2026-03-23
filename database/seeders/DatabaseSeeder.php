<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@nomado.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user@nomado.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Seed Countries
        $countries = [
            ['name' => 'Maroc', 'trip_type' => 'adventure', 'description' => 'Désert du Sahara, Atlas, Marrakech', 'image' => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Népal', 'trip_type' => 'adventure', 'description' => 'Himalaya, trekking, temples', 'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Espagne', 'trip_type' => 'culture', 'description' => 'Gaudi, musées, flamenco', 'image' => 'https://images.unsplash.com/photo-1543783207-ec64e4d95325?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Italie', 'trip_type' => 'culture', 'description' => 'Rome, Renaissance, gastronomie', 'image' => 'https://images.unsplash.com/photo-1498503182468-3b51fbb6cb1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Maldives', 'trip_type' => 'beach', 'description' => 'Plages de rêve, eau turquoise', 'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Thaïlande', 'trip_type' => 'beach', 'description' => 'Îles paradisiaques, temples', 'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'France', 'trip_type' => 'romantic', 'description' => 'Paris, châteaux de la Loire', 'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
            ['name' => 'Grèce', 'trip_type' => 'romantic', 'description' => 'Santorin, coucher de soleil', 'image' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
        ];

        foreach ($countries as $data) {
            \App\Models\Country::create($data);
        }

        // Seed Hotels for Maroc
        $maroc = \App\Models\Country::where('name', 'Maroc')->first();
        \App\Models\Hotel::create(['country_id' => $maroc->id, 'name' => 'Riad Marrakech', 'price_per_night' => 50, 'description' => 'Un riad traditionnel au cœur de la médina.', 'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);
        \App\Models\Hotel::create(['country_id' => $maroc->id, 'name' => 'Atlas Mountain', 'price_per_night' => 70, 'description' => 'Vue magnifique sur les montagnes.', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);
        \App\Models\Hotel::create(['country_id' => $maroc->id, 'name' => 'Desert Camp', 'price_per_night' => 45, 'description' => 'Passez la nuit sous les étoiles.', 'image' => 'https://images.unsplash.com/photo-1504150558240-0b4fd8946624?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);
        \App\Models\Hotel::create(['country_id' => $maroc->id, 'name' => 'Luxury Palace', 'price_per_night' => 150, 'description' => 'Le luxe à l\'état pur.', 'image' => 'https://images.unsplash.com/photo-1542314831-c6a4d27ce6a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80']);

        // Seed some random hotels for other countries
        $otherCountries = \App\Models\Country::where('name', '!=', 'Maroc')->get();
        foreach ($otherCountries as $country) {
            for ($i = 1; $i <= 3; $i++) {
                \App\Models\Hotel::create([
                    'country_id' => $country->id,
                    'name' => 'Hotel ' . $country->name . ' ' . $i,
                    'price_per_night' => rand(40, 200),
                    'description' => 'Beautiful hotel in ' . $country->name,
                    'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                ]);
            }
        }
    }
}
