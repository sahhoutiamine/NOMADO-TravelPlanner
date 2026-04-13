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
        // Admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@nomado.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Regular user
        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'user@nomado.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Application Seeders
        $this->call([
            CountrySeeder::class,
            PlaceSeeder::class,
            HotelSeeder::class,
        ]);
    }
}
