<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\CourierCheckController;


Route::post('/courier-check', [CourierCheckController::class, 'checkCourier']);


/**
 * @OA\Info(
 *      title="Laravel API Documentation",
 *      version="1.0.0",
 *      description="API documentation for the Laravel authentication system using Sanctum.",
 *      @OA\Contact(
 *          email="support@example.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
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

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'status' => 200
    ]);
});

Route::get('/version', function () {
    return response()->json([
        'framework' => app()->version(),
    ]);
});

// 🔹 Protected API routes (Require authentication)
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
    Route::get('/user', [ApiAuthController::class, 'user']);  // ✅ Keeps only one /user route
    Route::post('/logout', [ApiAuthController::class, 'logout']);
});

// 🔹 Fallback Route (Handles 404 for unknown API endpoints)
Route::fallback(function () {
    return response()->json(['message' => 'API route not found'], 404);
});

Route::get('/users', function () {
    return response()->json(User::select('id', 'username')->get());
});