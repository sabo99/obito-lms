<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function subscriptions()
    {
        return view('dashboard.subscriptions');
    }

    public function subscriptionDetails()
    {
        return view('dashboard.subscription-details');
    }
}
