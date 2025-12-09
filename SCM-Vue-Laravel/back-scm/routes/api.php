<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']); // Registration disabled for now

// Protected routes (requires Sanctum authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Authenticated user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Add more protected API routes here (role-based dashboard, etc.)
});
