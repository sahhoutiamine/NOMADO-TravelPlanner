<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->country(),
            'trip_type' => fake()->randomElement(['adventure', 'culture', 'beach', 'romantic', 'nature', 'shopping']),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl(),
        ];
    }
}
