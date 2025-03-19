<?php

namespace App\Http\Controllers\DeliveryPartnerController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\ECourierApiCredential; // ✅ Import Model

class ECourierController extends Controller
{
    private $baseUrl = "https://backoffice.ecourier.com.bd/api";

    /**
     * ✅ Verify E-Courier API Credentials & Store If Valid (Like RedX)
     */
    public function checkAndStoreCredentials(Request $request)
    {
        try {
            $data = $request->json()->all();
    
            // ✅ Validate input (Like RedX)
            $validator = Validator::make($data, [
                'business_id' => 'required|string|max:8', // ✅ Required for correct mapping
                'user_id' => 'required|string',
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
    
            // ✅ Step 1: Verify API Credentials before storing
            $verifyResponse = Http::withHeaders([
                'API-SECRET' => $data['api_secret'],
                'API-KEY' => $data['api_key'],
                'USER-ID' => $data['user_id'],
                'Content-Type' => 'application/json',
            ])->post("https://backoffice.ecourier.com.bd/api/packages");
    
            $verifyData = $verifyResponse->json();
    
            if (!$verifyResponse->successful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => '❌ Invalid API Credentials!',
                    'details' => $verifyData
                ], 401);
            }
    
            // ✅ Step 2: Store Credentials in `ecourier_api_credentials` Table (Like RedX)
            $credential = ECourierApiCredential::updateOrCreate(
                ['business_id' => $data['business_id']], // ✅ Prevent duplicate business_id
                [
                    'courier_name' => 'E-Courier',
                    'credentials' => json_encode([ // ✅ Storing as JSON
                        'user_id' => $data['user_id'],
                        'api_key' => $data['api_key'],
                        'api_secret' => $data['api_secret']
                    ])
                ]
            );
    
            return response()->json([
                'status' => 'success',
                'message' => 'Credentials verified & saved successfully!',
                'data' => $credential
            ], 201);
        } catch (\Throwable $e) {
            Log::error("E-Courier API Credential Storage Failed:", ['error' => $e->getMessage()]);
    
            return response()->json([
                'status' => 'error',
                'message' => '❌ Server error. Could not verify/store credentials.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
