<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EcourierController extends Controller
{
    /**
     * Display the ecourier credentials page.
     */
    public function index()
    {
        return view('ecouriers.index');
    }

    /**
     * Get business-specific ecourier data for the authenticated user.
     */
    public function getBusinessData(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the authenticated user's business_id
        $business_id = Auth::user()->business_id;

        // Fetch data from ecourier_api_credentials where business_id matches
        $data = DB::table('ecourier_api_credentials')
                    ->where('business_id', $business_id)
                    ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
