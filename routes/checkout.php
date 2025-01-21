<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:student'])
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {

        Route::get('/checkout/{pricing}', [CheckoutController::class, 'checkout'])
            ->name('pricing');

        // Generate Snap Token Midtrans
        Route::post('/booking/payment/midtrans', [CheckoutController::class, 'paymentStoreMidtrans'])
            ->name('payment_store_midtrans');

        Route::get('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])
            ->name('success');
    });

Route::match(['get', 'post'], '/booking/payment/midtrans/notification', [CheckoutController::class, 'paymentMidtransNotification'])
    ->name('checkout.payment_midtrans_notification');
