<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventOption;
use App\Models\EventPrice;
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

        User::factory(100)->create();
        Venue::factory(50)->create();
        Event::factory(10)->create()->each(function (Event $event) {
            $event->price()->save(EventPrice::factory()->make());
            $event->option()->save(EventOption::factory()->make());
        });;
        Transaction::factory(200)->create();
        Ticket::factory(1000)->create();

        Transaction::all()->each(function (Transaction $transaction): void {
            $transaction->update([
                'amount' => $transaction->tickets()->sum('price'),
            ]);
        });
    }
}
