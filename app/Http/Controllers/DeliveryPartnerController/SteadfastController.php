<?php

namespace App\Http\Controllers\DeliveryPartnerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SteadfastApiCredential;
use Illuminate\Support\Facades\Validator;

class SteadfastController extends Controller
{
    private $baseUrl = "https://portal.packzy.com/api/v1";

    /**
     * ✅ Step 1: Check balance before saving credentials
     */
    public function checkBalance(Request $request)
    {
        // ✅ Validate required fields
        $validator = Validator::make($request->all(), [
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // ✅ Send a GET request to check balance
            $response = Http::withHeaders([
                'Api-Key' => $request->api_key,
                'Secret-Key' => $request->api_secret,
                'Content-Type' => 'application/json'
            ])->get("$this->baseUrl/get_balance");

            $data = $response->json();

            // ✅ Log the API response
            Log::info('Steadfast API Balance Check:', [
                'status' => $response->status(),
                'response' => $data,
            ]);

            // ✅ Success: Return balance info
            if ($response->successful() && isset($data['status']) && $data['status'] == 200) {
                return response()->json([
                    'status' => 'success',
                    'message' => '✅ Verified! Balance: ' . $data['current_balance'],
                    'current_balance' => $data['current_balance']
                ], 200);
            }

            // ❌ Failure: Return API error
            return response()->json([
                'status' => 'error',
                'message' => '❌ Invalid API credentials. Check again.',
                'details' => $data
            ], 401);
        } catch (\Exception $e) {
            Log::error("Steadfast API Request Failed:", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => '❌ Server error. Could not verify credentials.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ✅ Step 2: Store credentials only if balance check is successful & prevent duplicate API Keys
     */
    public function storeCredentials(Request $request)
    {
        // ✅ Read JSON data properly
        $data = $request->json()->all();

        // ✅ Validate input fields
        $validator = Validator::make($data, [
            'business_id' => 'required|string|max:8',
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // ✅ Check if API Key already exists inside the credentials JSON field
            $existingRecord = SteadfastApiCredential::whereJsonContains('credentials', ['api_key' => $data['api_key']])->first();

            if ($existingRecord) {
                return response()->json([
                    'status' => 'error',
                    'message' => '❌ This API Key is already in use. Please use a different API Key.',
                ], 400);
            }

            // ✅ Verify API credentials by checking balance
            $balanceResponse = Http::withHeaders([
                'Api-Key' => $data['api_key'],
                'Secret-Key' => $data['api_secret'],
                'Content-Type' => 'application/json'
            ])->get("$this->baseUrl/get_balance");

            $balanceData = $balanceResponse->json();

            if (!$balanceResponse->successful() || !isset($balanceData['status']) || $balanceData['status'] != 200) {
                return response()->json([
                    'status' => 'error',
                    'message' => '❌ Invalid credentials. Cannot save API details.',
                    'details' => $balanceData
                ], 401);
            }

            // ✅ Store API Credentials (Prevent duplicate business_id)
            $credential = SteadfastApiCredential::updateOrCreate(
                ['business_id' => $data['business_id']], // ✅ Prevent duplicate entries for same business
                [
                    'courier_name' => 'Steadfast',
                    'credentials' => [
                        'api_key' => $data['api_key'],
                        'api_secret' => $data['api_secret']
                    ],
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => '✅ Credentials verified & stored successfully!',
                'data' => $credential
            ], 201);
        } catch (\Exception $e) {
            Log::error("Steadfast API Credential Storage Failed:", ['error' => $e->getMessage()]);

            return response()->json([
                'status' => 'error',
                'message' => '❌ Server error. Could not store credentials.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
