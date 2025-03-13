<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourierCheckController extends Controller
{
    /**
     * Fetch courier check data from external API.
     */
    public function showCourierCheck(Request $request)
    {
        // Validate phone input
        $request->validate([
            'phone' => 'required|string'
        ]);

        // API Key
        $apiKey = 'ZFouX7mvII3YBMEErMOJ6lFLBHZciiAfk8WTun9sL70uEPwVit4HK3fs1qLt';

        // API Endpoint
        $apiUrl = 'https://bdcourier.com/api/courier-check';

        // Make API Request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post($apiUrl, [
            'phone' => $request->phone
        ]);

        // If API fails, return an error
        if (!$response->successful()) {
            return back()->with('error', 'Failed to fetch courier data');
        }

        // Decode response and pass it to the view
        $apiData = $response->json();

        return view('courier-check-result', compact('apiData'));
    }
}
