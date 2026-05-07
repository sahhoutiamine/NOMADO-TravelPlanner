<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Specific users for testing
        User::updateOrCreate(
            ['email' => 'admin@nomado.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@nomado.com'],
            [
                'name' => 'Jane Doe',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        User::updateOrCreate(
            ['email' => 'travel@nomado.com'],
            [
                'name' => 'Travel Admin',
                'password' => Hash::make('password'),
                'role' => 'travlerAdmin',
            ]
        );

        // Create 10 more random users
        User::factory(10)->create();
    }
}
