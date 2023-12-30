<?php

namespace Database\Seeders;

use App\Models\TransactionState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionStateSeeder extends Seeder
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
                'description' => 'The transaction is pending.',
            ],
            [
                'name' => 'Waiting for Approval',
                'slug' => str::slug('waiting for approval'),
                'description' => 'The transaction is waiting for approval.',
            ],
            [
                'name' => 'Approved',
                'slug' => 'approved',
                'description' => 'The transaction has been approved.',
            ],
            [
                'name' => 'Rejected',
                'slug' => 'rejected',
                'description' => 'The transaction has been rejected.',
            ],
            [
                'name' => 'Cancelled',
                'slug' => 'cancelled',
                'description' => 'The transaction has been cancelled.',
            ],
        ];

        foreach ($states as $state) {
            TransactionState::updateOrCreate($state);
        }
    }
}
