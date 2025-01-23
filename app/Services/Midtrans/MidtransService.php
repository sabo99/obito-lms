<?php

namespace App\Services\Midtrans;

use Exception;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // Set Midtrains configuration
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');
    }

    /**
     * Create a Snap token using the provided parameters.
     *
     * @param array $params The parameters required to create the Snap token.
     * @return string The generated Snap token.
     */
    public function createSnapToken(array $params): string
    {
        try {
            return \Midtrans\Snap::getSnapToken($params);
        } catch (Exception $e) {
            Log::error('MidtransService@createSnapToken: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle the notification from Midtrans.
     *
     * This method processes the notification received from Midtrans and returns an array with the results.
     *
     * @return array The result of the notification handling.
     */
    public function handleNotification(): array
    {
        try {
            $notification = new \Midtrans\Notification();
            return [
                'order_id' => $notification->order_id,
                'transaction_status' => $notification->transaction_status,
                'gross_amount' => $notification->gross_amount,
                'custom_field1' => $notification->custom_field1, // User ID
                'custom_field2' => $notification->custom_field2, // Pricing ID
                'payment_type' => $notification->payment_type,
                // 'transaction_time' => $notification->transaction_time,
                // 'transaction_id' => $notification->transaction_id,
                // 'fraud_status' => $notification->fraud_status,
                // 'status_message' => $notification->status_message,
                // 'status_code' => $notification->status_code,
                // 'signature_key' => $notification->signature_key,
            ];
        } catch (Exception $e) {
            Log::error('MidtransService@handleNotification: ' . $e->getMessage());
            throw $e;
        }
    }
}
