<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'country_id' => \App\Models\Country::factory(),
            'hotel_id' => \App\Models\Hotel::factory(),
            'trip_type' => fake()->randomElement(['adventure', 'culture', 'beach', 'romantic', 'nature', 'shopping']),
            'budget_total' => fake()->randomFloat(2, 1000, 5000),
            'duration' => fake()->numberBetween(3, 14),
            'passengers' => fake()->numberBetween(1, 4),
            'flight_budget' => fake()->randomFloat(2, 200, 1000),
            'hotel_budget' => fake()->randomFloat(2, 300, 1500),
            'activities_budget' => fake()->randomFloat(2, 100, 500),
            'misc_budget' => fake()->randomFloat(2, 50, 300),
            'total_price' => fake()->randomFloat(2, 800, 4000),
            'status' => fake()->randomElement(['pending', 'paid']),
        ];
    }
}
