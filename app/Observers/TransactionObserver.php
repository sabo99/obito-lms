<?php

namespace App\Observers;

use App\Helpers\TransactionHelper;
use App\Models\Transaction;

class TransactionObserver
{
    public function creating($transaction): void
    {
        // Generate the transaction id
        $transaction->booking_trx_id = TransactionHelper::generateUniqueTransactionId();
    }

    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        // ...
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        // ...
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        // ...
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        // ...
    }

    /**
     * Handle the Transaction "forceDeleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        // ...
    }
}
