<?php

namespace App\Observers;

use App\Models\TicketState;
use App\Models\Transaction;
use App\Models\TransactionState;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        switch ($transaction->state->slug) {
            case TransactionState::APPROVED:
                $transaction->tickets()->update([
                    'state_id' => TicketState::find(TicketState::APPROVED)->id
                ]);
                break;
            case TransactionState::CANCELLED:
                $transaction->tickets()->delete();
                break;
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
