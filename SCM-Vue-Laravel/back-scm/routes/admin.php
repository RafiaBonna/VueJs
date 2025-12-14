<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
| This file is loaded from routes/api.php
|
| Purpose:
|   /api/admin/users
|   /api/admin/depos
|   /api/admin/suppliers
|
| Controller Namespace:
|   App\Http\Controllers\Api\Admin
|
| Middleware:
|   auth:sanctum
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])
    ->prefix('admin') // URL prefix: /api/admin/...
    ->namespace('App\Http\Controllers\Api\Admin')
    ->group(function () {

        // --------------------------------------------------
        // User Management
        // URL: /api/admin/users
        // --------------------------------------------------
        Route::apiResource('users', 'UserController');

        // --------------------------------------------------
        // Depo Management (Full CRUD)
        // URL: /api/admin/depos
        // --------------------------------------------------
        Route::apiResource('depos', 'DepoController');

        // --------------------------------------------------
        // Supplier Management
        // URL: /api/admin/suppliers
        // --------------------------------------------------
        Route::apiResource('suppliers', 'SupplierController');

        // --------------------------------------------------
        // Future admin-related controllers can be added here
        // --------------------------------------------------
    });
