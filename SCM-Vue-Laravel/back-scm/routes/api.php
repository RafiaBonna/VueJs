<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (MAIN FILE)
|--------------------------------------------------------------------------
*/

// ------------------------------
// Public Routes
// ------------------------------
Route::post('/login', [AuthController::class, 'login']);

// ------------------------------
// Protected Routes - Requires Sanctum Auth
// ------------------------------
Route::middleware('auth:sanctum')->group(function () {

    // General Auth Endpoints (Kept here for simplicity)
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // =====================================================
    // ✅ Modular Route Loading (File-to-File Linking)
    // =====================================================
    
    // Admin, Depo, Distributor-এর সব রুট এখন তাদের নিজস্ব ফাইল থেকে লোড হবে।
    
    require __DIR__ . '/admin.php'; 
    require __DIR__ . '/depo.php'; 
    require __DIR__ . '/distributor.php'; 
});