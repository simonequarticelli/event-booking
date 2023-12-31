<?php

namespace Database\Factories;

use App\Models\TransactionState;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'user_id' => User::all()->random(),
            'transaction_state_id' => TransactionState::all()->random(),
            'amount' => fake()->randomFloat('2', '10', '1000'),
        ];
    }
}
