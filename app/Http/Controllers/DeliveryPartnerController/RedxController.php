<?php

namespace App\Http\Controllers\DeliveryPartnerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\RedxApiCredential;
use Illuminate\Support\Facades\Validator;

class RedxController extends Controller
{
    private $baseUrl = "https://openapi.redx.com.bd/v1.0.0-beta";

    /**
     * ✅ Verify Access Token using GET request
     */
    public function verifyAccessToken(Request $request)
{
    // ✅ Get access token from request
    $accessToken = $request->query('access_token'); // Ensure it's reading from query parameters

    if (!$accessToken) {
        return response()->json([
            'status' => 'error',
            'message' => '❌ Access Token is required!'
        ], 400);
    }

    try {
        // ✅ Send a GET request to RedX API to verify the token
        $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => "Bearer $accessToken"
        ])->get("https://openapi.redx.com.bd/v1.0.0-beta/pickup/stores");

        $data = $response->json();
        Log::info('📡 RedX API Response:', $data);

        if ($response->successful() && isset($data['pickup_stores'])) {
            return response()->json([
                'status' => 'success',
                'message' => '✅ Valid Access Token!',
                'data' => $data
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => '❌ Invalid Access Token!',
            'details' => $data
        ], 401);
    } catch (\Exception $e) {
        Log::error("❌ RedX API Verification Failed:", ['error' => $e->getMessage()]);

        return response()->json([
            'status' => 'error',
            'message' => '❌ Server error. Could not verify token.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * ✅ Store RedX API credentials
     */
    public function storeCredentials(Request $request)
    {
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'business_id' => 'required|string|max:8',
            'access_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // ✅ Verify access token before saving
            $verifyResponse = Http::withHeaders([
                'API-ACCESS-TOKEN' => "Bearer {$data['access_token']}"
            ])->get("{$this->baseUrl}/pickup/stores");

            $verifyData = $verifyResponse->json();

            if (!$verifyResponse->successful() || !isset($verifyData['pickup_stores'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => '❌ Invalid access token!',
                    'details' => $verifyData
                ], 401);
            }

            // ✅ Store Credentials in Database
            $credential = RedxApiCredential::updateOrCreate(
                ['business_id' => $data['business_id']], 
                ['courier_name' => 'RedX', 'credentials' => ['access_token' => $data['access_token']]]
            );

            return response()->json([
                'status' => 'success',
                'message' => '✅ Credentials saved successfully!',
                'data' => $credential
            ], 201);
        } catch (\Exception $e) {
            Log::error("RedX API Credential Storage Failed:", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => '❌ Server error. Could not store credentials.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
