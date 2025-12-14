<?php

use Illuminate\Support\Facades\Route;

// Depo API Routes
Route::middleware(['auth:sanctum'])
    ->prefix('depo') // URL-এ /depo যোগ করবে
    ->namespace('App\Http\Controllers\Api\Depo') // Controller-এর লোকেশন
    ->group(function () {
        // Depo-এর রুট এখানে যোগ হবে (যেমন: Route::resource('stocks', 'StockController');)
    });