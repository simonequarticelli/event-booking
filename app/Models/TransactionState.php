<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionState extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const WAITING_FOR_APPROVAL = 'waiting-for-approval';
    const APPROVED = 'approved';
    const CANCELLED = 'cancelled';

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
