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
            'ticket_state_id' => TicketState::all()->random(),
            'transaction_id' => Transaction::all()->random(),
            'price' => fake()->randomFloat('2', '10', '1000'),
        ];
    }
}
