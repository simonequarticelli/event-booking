<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TicketStateSeeder::class,
            TransactionStateSeeder::class,
        ]);

        User::factory(10)->create();
        Venue::factory(500)->create();
        Event::factory(1000)->create();

        Transaction::factory(500)
            ->hasTickets(fake()->numberBetween(1, 5))
            ->create();

        Transaction::all()->each(function (Transaction $transaction): void {
            $transaction->update([
                'amount' => $transaction->tickets()->sum('price')
            ]);
        });
    }
}
