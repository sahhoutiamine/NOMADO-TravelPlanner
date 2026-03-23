<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => \App\Models\Country::factory(),
            'name' => fake()->company() . ' Hotel',
            'price_per_night' => fake()->randomFloat(2, 40, 300),
            'description' => fake()->paragraph(),
            'image' => fake()->imageUrl(),
        ];
    }
}
