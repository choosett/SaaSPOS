<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\CourierCheckController;
use App\Http\Controllers\LocationSearchController;
use App\Http\Controllers\DeliveryPartnerController\PathaoController;
use App\Http\Controllers\DeliveryPartnerController\RedxController;
use App\Http\Controllers\DeliveryPartnerController\SteadfastController;
use App\Http\Controllers\DeliveryPartnerController\ECourierController;
use App\Models\User;

// ✅ Authentication Routes
Route::post('/login', [ApiAuthController::class, 'login'])->name('api.login');
Route::middleware('auth:sanctum')->post('/logout', [ApiAuthController::class, 'logout']);

// ✅ Protected User Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user'])->name('api.user');
    Route::post('/update-activity', [ApiAuthController::class, 'updateActivity']);
});

// ✅ Delivery Partner API Routes
Route::prefix('delivery-partner')->group(function () {
    Route::prefix('pathao')->group(function () {
        Route::post('/store-credentials', [PathaoController::class, 'verifyAndStoreCredentials']);
        Route::post('/refresh-token', [PathaoController::class, 'refreshAccessToken']);
    });

    Route::prefix('redx')->group(function () {
        Route::get('/verify-access-token', [RedxController::class, 'verifyAccessToken']);
        Route::post('/store-credentials', [RedxController::class, 'storeCredentials']);
    });

    Route::prefix('steadfast')->group(function () {
        Route::get('/check-balance', [SteadfastController::class, 'checkBalance']);
        Route::post('/store-credentials', [SteadfastController::class, 'storeCredentials']);
    });

    Route::prefix('ecourier')->group(function () {
        Route::middleware('auth:sanctum')->post('/check-and-store-credentials', [ECourierController::class, 'checkAndStoreCredentials']);
    });
});

// ✅ Location Search API
Route::get('/location/match', [LocationSearchController::class, 'matchLocation']);

// ✅ Courier Check
Route::post('/courier-check', [CourierCheckController::class, 'checkCourier']);

// ✅ Debugging - Get Users (Restricted to Admin)
Route::middleware(['auth:sanctum', 'role:admin'])->get('/users', function () {
    return response()->json(User::select('id', 'username')->get());
});

// ✅ Public API Version Endpoint
Route::get('/version', fn() => response()->json(['framework' => app()->version()]));

// ✅ API Documentation (Swagger)
/**
 * @OA\Info(
 *      title="Laravel API Documentation",
 *      version="1.0.0",
 *      description="API documentation for the Laravel authentication system using Sanctum.",
 *      @OA\Contact(email="support@example.com"),
 *      @OA\License(name="Apache 2.0", url="http://www.apache.org/licenses/LICENSE-2.0.html")
 * )
 *
 * @OA\Server(
 *      url="http://127.0.0.1:8000",
 *      description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      description="Enter your Bearer token in the field. Example: Bearer your_api_token_here"
 * )
 */

// ✅ Handle 404 API Routes
Route::fallback(function () {
    Log::warning("🚨 Unknown API request: " . request()->fullUrl());
    return response()->json(['message' => 'API route not found'], 404);
});
