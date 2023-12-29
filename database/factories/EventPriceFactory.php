<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventPrice>
 */
class EventPriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::all()->random(),
            'standard' => fake()->randomFloat('2', '10', '100'),
            'premium' => fake()->randomFloat('2', '50', '200'),
            'gold' => fake()->randomFloat('2', '100', '350'),
        ];
    }
}
