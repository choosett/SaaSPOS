<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\CourierCheckController;
use App\Http\Controllers\LocationSearchController;
use App\Http\Controllers\DeliveryPartnerController\PathaoController;
use App\Models\User;
use App\Models\PathaoLocation;
use App\Http\Controllers\DeliveryPartnerController\RedxController;
use App\Http\Controllers\DeliveryPartnerController\SteadfastController;
use App\Http\Controllers\DeliveryPartnerController\ECourierController;


Route::post('/pathao/store-credentials', [PathaoController::class, 'verifyAndStoreCredentials']);
Route::post('/pathao/refresh-token', [PathaoController::class, 'refreshAccessToken']);





// ✅ Ensure this block is inside routes/api.php

Route::post('/ecourier/check-and-store-credentials', [ECourierController::class, 'checkAndStoreCredentials']);



// ✅ RedX API Routes
Route::get('/redx/verify-access-token', [RedxController::class, 'verifyAccessToken']);
Route::post('/redx/store-credentials', [RedxController::class, 'storeCredentials']);

// ✅ Steadfast API Routes
Route::get('/steadfast/check-balance', [SteadfastController::class, 'checkBalance']); 
Route::post('/steadfast/store-credentials', [SteadfastController::class, 'storeCredentials']); 







// 🔹 Location Match Route
Route::get('/location/match', [LocationSearchController::class, 'matchLocation']);

// 🔹 Courier Check
Route::post('/courier-check', [CourierCheckController::class, 'checkCourier']);

// 🔹 Public API Documentation
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
 *      description="Enter your Bearer token in the field"
 * )
 */

// 🔹 Public Routes (No authentication required)
/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="User Login",
 *     description="Authenticate user and return an access token.",
 *     operationId="loginUser",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="password123")
 *         ),
 *     ),
 *     @OA\Response(response=200, description="Successful login"),
 *     @OA\Response(response=401, description="Invalid credentials")
 * )
 */
Route::post('/login', [ApiAuthController::class, 'login']);


Route::get('/version', fn() => response()->json(['framework' => app()->version()]));

// 🔹 Protected API Routes (Require authentication)
/**
 * @OA\Get(
 *     path="/api/user",
 *     summary="Get Authenticated User",
 *     description="Returns the authenticated user details",
 *     operationId="getAuthenticatedUser",
 *     tags={"User"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Response(response=200, description="Authenticated user details"),
 *     @OA\Response(response=401, description="Unauthenticated")
 * )
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);  
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    

});




// 🔹 Fallback Route (Handles 404 for unknown API endpoints)
Route::fallback(fn() => response()->json(['message' => 'API route not found'], 404));

// 🔹 Get All Users (Debugging)
Route::get('/users', function () {
    return response()->json(User::select('id', 'username')->get());
});

