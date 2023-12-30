<?php

namespace App\Services;

use App\Models\TransactionState;
use App\Models\User;

class UserService
{
    public static function pendingTransaction()
    {
        // auth()->user()
        return User::find(1)->transactions()->with('state', function ($query) {
            $query->where('slug', [TransactionState::PENDING]);
        });
    }

    public function pendingTickets()
    {
        return self::pendingTransaction()->first()->tickets();
    }
}
