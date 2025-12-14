<?php

use Illuminate\Support\Facades\Route;

// Distributor API Routes
Route::middleware(['auth:sanctum'])
    ->prefix('distributor') // URL-এ /distributor যোগ করবে
    ->namespace('App\Http\Controllers\Api\Distributor') // Controller-এর লোকেশন
    ->group(function () {
        // Distributor-এর রুট এখানে যোগ হবে (যেমন: Route::resource('orders', 'OrderController');)
    });