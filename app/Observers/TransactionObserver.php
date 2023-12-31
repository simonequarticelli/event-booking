<?php

namespace App\Observers;

use App\Events\TransactionProcessed;
use App\Models\TicketState;
use App\Models\Transaction;
use App\Models\TransactionState;
use Illuminate\Support\Facades\Log;

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
                    'ticket_state_id' => TicketState::firstWhere('slug', TicketState::APPROVED)->id
                ]);
                break;
            case TransactionState::REJECTED:
                Log::info($transaction->tickets);
                $transaction->tickets()->delete();
                break;
        }

        TransactionProcessed::dispatch($transaction, $transaction->state->slug);
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
