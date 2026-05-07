<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $budgetTotal = fake()->randomFloat(2, 500, 5000);
        $flightBudget = $budgetTotal * 0.4;
        $hotelBudget = $budgetTotal * 0.3;
        $activitiesBudget = $budgetTotal * 0.2;
        $miscBudget = $budgetTotal * 0.1;

        return [
            'city_id' => City::inRandomOrder()->first()?->id ?? 1,
            'trip_type' => fake()->randomElement(['adventure', 'culture', 'beach', 'romantic', 'nature']),
            'budget_total' => $budgetTotal,
            'departure_date' => fake()->dateTimeBetween('now', '+1 year'),
            'duration' => fake()->numberBetween(3, 14),
            'passengers' => fake()->numberBetween(1, 5),
            'flight_budget' => $flightBudget,
            'hotel_budget' => $hotelBudget,
            'activities_budget' => $activitiesBudget,
            'misc_budget' => $miscBudget,
            'status' => fake()->randomElement(['pending', 'paid']),
            'share_code' => strtoupper(Str::random(6)),
            'include_hotel' => fake()->boolean(80),
            'departure_city_id' => City::inRandomOrder()->first()?->id ?? 1,
            'flight_airline' => fake()->company(),
            'flight_class' => fake()->randomElement(['Economy', 'Business', 'First Class']),
            'flight_duration' => fake()->numberBetween(1, 15) . ' hours',
        ];
    }
}
