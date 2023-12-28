<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $venue = Venue::factory()->create();

        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'seats' => fake()->numberBetween(1, $venue->capacity),
            'venue_id' => $venue->id,
            'start_date' => fake()->dateTimeBetween('+2 week', '+1 year'),
            'end_date' => fake()->dateTimeBetween('+3 months', '+2 years'),
            'image' => fake()->imageUrl(),
            'social_link' => fake()->url(),
        ];
    }
}
