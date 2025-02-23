<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
 *      url="http://127.0.0.1:8001",
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
 *
 * @OA\Tag(name="Authentication", description="API Endpoints for User Authentication")
 */
class ApiAuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User Login",
     *     description="Authenticate user by email/username and return an access token.",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"identifier","password"},
     *             @OA\Property(property="identifier", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         ),
     *     ),
     *     @OA\Response(response=200, description="Successful login"),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->identifier)
                    ->orWhere('username', $request->identifier)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->tokens()->count() >= 3) {
            $user->tokens()->oldest()->first()->delete();
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Login successful',
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="User Logout",
     *     description="Logout the authenticated user and revoke token.",
     *     operationId="logoutUser",
     *     tags={"Authentication"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Header(
     *         header="Authorization",
     *         description="Bearer {token}",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer your_token_here"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token Required",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get Authenticated User",
     *     description="Returns the authenticated user details",
     *     operationId="getAuthenticatedUser",
     *     tags={"Authentication"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Header(
     *         header="Authorization",
     *         description="Bearer {token}",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer your_token_here"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="wasik1220"),
     *                 @OA\Property(property="email", type="string", example="wasik1220@gmail.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-23T08:05:57.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-23T08:05:57.000000Z")
     *             ),
     *             @OA\Property(property="message", type="string", example="Authenticated API call successful!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Token Required",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'message' => 'Authenticated API call successful!',
        ], 200);
    }
}
