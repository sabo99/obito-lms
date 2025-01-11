<?php

namespace App\Helpers;

use App\Models\Transaction;

class TransactionHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function generateUniqueTransactionId(): string
    {
        // Generate the unique transaction id
        $prefix = 'TRX';
        do {
            $randomString = $prefix.mt_rand(10000, 99999);
        } while (Transaction::where('booking_trx_id', $randomString)->exists());

        return $randomString;
    }
}
