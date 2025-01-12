<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:student'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/subscriptions', [DashboardController::class, 'subscriptions'])
            ->name('subscriptions');
        Route::get('/subscriptions/{transaction}', [DashboardController::class, 'subscriptionDetails'])
            ->name('subscription.details');

        Route::get('/courses', [CourseController::class, 'index'])
            ->name('courses');
        Route::get('/courses/{course:slug}', [CourseController::class, 'details'])
            ->name('courses.details');
        Route::get('/courses/search/courses', [CourseController::class, 'searchCourses'])
            ->name('courses.search');

        Route::middleware('check.subscription')->group(function () {

            Route::get('/join/{course:slug}', [CourseController::class, 'join'])
                ->name('courses.join');
            Route::get('/learning/{course:slug}/{courseSection}/{sectionContent}', [CourseController::class, 'learning'])
                ->name('courses.learning');
            Route::get('/learning/{course:slug}/finished', [CourseController::class, 'learningFinished'])
                ->name('courses.learning.finished');
        });
    });
