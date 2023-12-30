<?php

namespace App\Services;

use App\Models\TransactionState;

class UserService
{
    public static function pendingTransaction()
    {
        return auth()->user()->transactions()->whereHas('state', function ($query) {
            $query->where('slug', TransactionState::PENDING);
        });
    }

    public function pendingTickets()
    {
        return self::pendingTransaction()->first()->tickets();
    }
}
