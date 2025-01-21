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
            \App\Repositories\PricingRepositoryInterface::class,
            \App\Repositories\PricingRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Course\CourseRepositoryInterface::class,
            \App\Repositories\Course\CourseRepository::class
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
