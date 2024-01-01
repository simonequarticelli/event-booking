<?php

namespace App\Services;

use App\Models\TransactionState;
use Exception;

class UserService
{
    public static function pendingTransaction()
    {
        return auth()->user()->transactions()->whereHas('state', function ($query) {
            $query->where('slug', TransactionState::PENDING);
        });
    }

    /**
     * @throws Exception
     */
    public function pendingTickets()
    {
        if (empty(self::pendingTransaction()->first())) {
            throw new Exception('No pending transaction found.');
        }

        return self::pendingTransaction()->first()->tickets();
    }
}
