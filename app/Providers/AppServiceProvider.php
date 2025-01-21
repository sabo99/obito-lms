<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Pricing\PricingRepositoryInterface::class,
            \App\Repositories\Pricing\PricingRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Course\CourseRepositoryInterface::class,
            \App\Repositories\Course\CourseRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Transaction\TransactionRepositoryInterface::class,
            \App\Repositories\Transaction\TransactionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
