<?php

namespace App\Http\Controllers\DeliveryPartnerController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CourierController extends Controller
{
    /**
     * ✅ Show Courier List (Main Page)
     */
    public function index(Request $request)
    {
        Log::info("🚀 Incoming request to CourierController@index", [
            'query_params' => $request->query(),
            'user' => auth()->user() ? auth()->user()->id : 'Guest'
        ]);
    
        // Check if business_id exists in request
        $businessId = $request->query('business_id');
        if (!$businessId) {
            Log::error("❌ Business ID is missing in request!");
            return abort(400, "Business ID is required!");
        }
    
        Log::info("✅ Business ID Found:", ['business_id' => $businessId]);
    
        $couriers = [
            'pathao' => DB::table('pathao_api_credentials')->where('business_id', $businessId)->first(),
            'steadfast' => DB::table('steadfast_api_credentials')->where('business_id', $businessId)->first(),
            'redx' => DB::table('redx_api_credentials')->where('business_id', $businessId)->first(),
            'ecourier' => DB::table('ecourier_api_credentials')->where('business_id', $businessId)->first(),
        ];
    
        Log::info("🚚 Couriers Data Retrieved", ['couriers' => $couriers]);
    
        return view('DeliveryPartner.index', compact('couriers'));
    }
    
    /**
     * ✅ Show API Settings Page for a Specific Courier
     */
    public function showApiSettings($courier)
    {
        Log::info("📥 Loading API Settings Page for Courier:", ['courier' => $courier]);

        $viewPath = "DeliveryPartner.partials.api.{$courier}_api";
        
        if (!view()->exists($viewPath)) {
            Log::error("❌ API Settings View Not Found:", ['view' => $viewPath]);
            abort(404, "API settings page not found.");
        }

        return view($viewPath);
    }

    /**
     * ✅ Show Settings Page for a Specific Courier
     */
    public function showSettings($courier)
    {
        Log::info("📥 Loading Settings Page for Courier:", ['courier' => $courier]);

        $viewPath = "DeliveryPartner.partials.Settings.{$courier}_settings";
        
        if (!view()->exists($viewPath)) {
            Log::error("❌ Settings View Not Found:", ['view' => $viewPath]);
            abort(404, "Settings page not found.");
        }

        return view($viewPath);
    }
}
