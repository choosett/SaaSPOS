<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This file defines API routes for the Laravel application. These routes
| are automatically loaded from `bootstrap/app.php` in Laravel 11.
|
*/

// 🔹 Public Route: Test API response
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'status' => 200
    ]);
});

// 🔹 Public Route: Return Laravel version
Route::get('/version', function () {
    return response()->json([
        'framework' => app()->version(),
    ]);
});

// 🔹 Protected Route (Requires Sanctum authentication)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'message' => 'Authenticated API call successful!'
    ]);
});

// 🔹 Fallback Route (Handles 404 for unknown API endpoints)
Route::fallback(function () {
    return response()->json(['message' => 'API route not found'], 404);
});
