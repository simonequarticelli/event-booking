<?php

namespace App\Listeners;

use App\Events\TransactionProcessed;
use App\Mail\TransactionProcessed as TransactionProcessedMail;
use Illuminate\Support\Facades\Mail;

class SendEmailTransactionStateNotification
{
    /**
     * Handle the event.
     */
    public function handle(TransactionProcessed $event): void
    {
        Mail::to(auth()->user()->email)->send(new TransactionProcessedMail($event->transaction, $event->stateSlug));
    }
}
