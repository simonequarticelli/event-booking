<?php

namespace App\Services;

use App\Models\TransactionState;
use App\Models\User;

class UserService
{
    public function getActiveTransaction()
    {
        // auth()->user()
        return User::find(1)->transactions()->with('state', function ($query) {
            $query->where('slug', [TransactionState::PENDING]);
        })->first();
    }
}
