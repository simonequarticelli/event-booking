<?php

namespace Database\Seeders;

use App\Models\TicketState;
use Illuminate\Database\Seeder;

class TicketStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            [
                'name' => 'Pending',
                'slug' => 'pending',
                'description' => 'The ticket is awaiting approval.',
            ],
            [
                'name' => 'Approved',
                'slug' => 'approved',
                'description' => 'The ticket was granted.',
            ],
            [
                'name' => 'Rejected',
                'slug' => 'rejected',
                'description' => 'The ticket was rejected.',
            ],
        ];

        foreach ($states as $state) {
            TicketState::updateOrCreate($state);
        }
    }
}
