<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@nomado.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'user@nomado.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Travel Admin',
            'email' => 'travel@nomado.com',
            'password' => bcrypt('password'),
            'role' => 'travlerAdmin',
        ]);

        $this->call([
            CountrySeeder::class,
            CitySeeder::class,
            PlaceSeeder::class,
            HotelSeeder::class,
        ]);
    }
}
