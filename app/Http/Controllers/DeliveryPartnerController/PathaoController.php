<?php

namespace App\Http\Controllers\DeliveryPartnerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\PathaoApiCredential;
use Illuminate\Support\Facades\Validator;

class PathaoController extends Controller
{
    private $baseUrl = "https://api-hermes.pathao.com";

    /**
     * ✅ Store Pathao API credentials after fetching access token
     */
    public function storeCredentials(Request $request)
    {
        $data = $request->json()->all();
    
        // ✅ Step 1: Validate input fields (Ensure `business_id` is required, like RedX & E-Courier)
        $validator = Validator::make($data, [
            'business_id' => 'required|string|max:8', // ✅ Now required from frontend
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'username' => 'required|email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Validation failed!',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        try {
            // ✅ Step 2: Call Pathao API for token verification
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://api-hermes.pathao.com/aladdin/api/v1/issue-token", [
                "client_id" => $data['client_id'],
                "client_secret" => $data['client_secret'],
                "grant_type" => "password",
                "username" => $data['username'],
                "password" => $data['password'],
            ]);
    
            $apiResponse = $response->json();
    
            // ✅ Log API Response
            Log::info('📡 Pathao API Response:', [
                'status' => $response->status(),
                'response' => $apiResponse,
            ]);
    
            // ✅ Step 3: Handle successful token retrieval
            if ($response->successful() && isset($apiResponse['access_token'])) {
                $business_id = $data['business_id']; // ✅ Collected from frontend request
    
                // ✅ Auto-generate `courier_id` (Like RedX & E-Courier)
                $latestCourier = PathaoApiCredential::latest('courier_id')->first();
                $nextId = $latestCourier ? ((int) substr($latestCourier->courier_id, 2)) + 1 : 1001;
                $courier_id = 'P-' . $nextId;
    
                // ✅ Step 4: Store credentials in database (Like RedX)
                $credential = PathaoApiCredential::updateOrCreate(
                    ['business_id' => $business_id], // ✅ Prevent duplicates for the same business
                    [
                        'courier_id' => $courier_id, // ✅ Auto-generated ID
                        'courier_name' => 'Pathao',
                        'credentials' => [
                            'username' => $data['username'],
                            'client_id' => $data['client_id'],
                            'client_secret' => $data['client_secret'],
                            'access_token' => $apiResponse['access_token'],
                            'refresh_token' => $apiResponse['refresh_token'] ?? null,
                            'expires_in' => $apiResponse['expires_in'] ?? 3600,
                        ],
                    ]
                );
    
                return response()->json([
                    'status' => 'success',
                    'message' => '✅ Credentials verified & stored successfully!',
                    'data' => $credential,
                ], 201);
            }
    
            return response()->json([
                'status' => 'error',
                'message' => $apiResponse['error'] ?? 'Invalid credentials. Please check again.',
                'details' => $apiResponse,
            ], 401);
        } catch (\Exception $e) {
            Log::error("Pathao API Request Failed:", ['error' => $e->getMessage()]);
    
            return response()->json([
                'status' => 'error',
                'message' => '❌ Server error. Could not verify credentials.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    



    /**
     * ✅ Refresh Access Token using Business ID
     */
    public function refreshAccessToken(Request $request)
    {
        // ✅ Step 1: Validate input (Require business_id from frontend)
        $validator = Validator::make($request->all(), [
            'business_id' => 'required|string|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Validation failed!',
                'errors' => $validator->errors(),
            ], 422);
        }

        $business_id = $request->business_id;

        // ✅ Step 2: Retrieve credentials for the given business ID
        $credential = PathaoApiCredential::where('business_id', $business_id)->first();

        if (!$credential) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ No credentials found for this business ID.'
            ], 404);
        }

        $credentials = $credential->credentials;

        // ✅ Step 3: Ensure the refresh token exists
        if (!isset($credentials['refresh_token'])) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ No refresh token found. Please log in again to obtain a new access token.'
            ], 400);
        }

        try {
            // ✅ Step 4: Request a new access token using the refresh token
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("$this->baseUrl/aladdin/api/v1/issue-token", [
                "client_id" => $credentials['client_id'],
                "client_secret" => $credentials['client_secret'],
                "grant_type" => "refresh_token",
                "refresh_token" => $credentials['refresh_token'],
            ]);

            $data = $response->json();

            // ✅ Step 5: If successful, update stored credentials
            if ($response->successful() && isset($data['access_token'])) {
                $credential->update([
                    'credentials' => array_merge($credentials, [
                        'access_token' => $data['access_token'],
                        'refresh_token' => $data['refresh_token'], // ✅ Store the new refresh token
                        'expires_in' => $data['expires_in'],
                    ])
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => '✅ Access token refreshed successfully!',
                    'new_access_token' => $data['access_token']
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => '❌ Token refresh failed.',
                'details' => $data
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Server error. Could not refresh token.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
