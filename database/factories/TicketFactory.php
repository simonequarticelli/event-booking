<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\TicketState;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'state_id' => TicketState::factory(),
            'transaction_id' => Transaction::factory(),
            'price' => fake()->price(),
        ];
    }
}
