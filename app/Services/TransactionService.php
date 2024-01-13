<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionState;

class TransactionService
{
    public function getOrCreateTransaction($pendingTransaction)
    {
        if (empty($pendingTransaction)) {
            return Transaction::create([
                'uuid' => fake()->uuid(),
                'user_id' => auth()->user()->id,
                'transaction_state_id' => TransactionState::where('slug', TransactionState::PENDING)->first()->id,
                'amount' => 0,
            ]);
        }

        return $pendingTransaction;
    }
}
