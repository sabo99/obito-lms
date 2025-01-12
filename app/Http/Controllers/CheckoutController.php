<?php

namespace App\Http\Controllers;

class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('welcome');
    }

    public function paymentStoreMidtrans()
    {
        return redirect()->route('checkout.success');
    }

    public function checkoutSuccess()
    {
        return view('welcome');
    }

    public function paymentMidtransNotification()
    {
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Midtrans Payment Notification Success',
        ]);
    }
}
