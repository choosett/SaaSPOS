<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BarikoiController extends Controller
{
    public function fetchSuggestions(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('BARIKOI_API_KEY');
    
        $response = Http::get("https://barikoi.xyz/v2/api/search/autocomplete/place", [
            'api_key' => $apiKey,
            'q' => $query,
            'sub_area' => 'true',
            'sub_district' => 'true'
        ]);
    
        Log::info("Barikoi API Response:", $response->json());
    
        return response()->json($response->json());
    }
    
}
