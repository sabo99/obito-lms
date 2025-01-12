<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/dashboard.php';
require __DIR__ . '/checkout.php';
