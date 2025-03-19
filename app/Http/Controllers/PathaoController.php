<?php

namespace App\Http\Controllers;

use App\Models\PathaoLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PathaoController extends Controller
{
    public function storePathaoData()
    {
        ini_set('max_execution_time', 21600); // 6 hours

        $accessToken = $this->getPathaoAccessToken();
        if (!$accessToken) {
            return response()->json(['error' => 'Failed to get access token'], 500);
        }

        $baseUrl = "https://api-hermes.pathao.com/aladdin/api/v1";

        try {
            $citiesResponse = Http::withToken($accessToken)->get("$baseUrl/city-list");
            $cities = $citiesResponse->json()['data']['data'] ?? [];

            foreach ($cities as $city) {
                $cityId = $city['city_id'];
                $cityName = trim($city['city_name']);

                $zonesResponse = Http::withToken($accessToken)->get("$baseUrl/cities/$cityId/zone-list");
                $zones = $zonesResponse->json()['data']['data'] ?? [];

                foreach ($zones as $zone) {
                    $zoneId = $zone['zone_id'];
                    $zoneName = trim($zone['zone_name']);

                    $areasResponse = Http::withToken($accessToken)->get("$baseUrl/zones/$zoneId/area-list");
                    $areas = $areasResponse->json()['data']['data'] ?? [];

                    foreach ($areas as $area) {
                        PathaoLocation::updateOrCreate(
                            [
                                'city_id' => $cityId,
                                'zone_id' => $zoneId,
                                'area_id' => $area['area_id'],
                            ],
                            [
                                'city_name' => $cityName,
                                'zone_name' => $zoneName,
                                'area_name' => trim($area['area_name']),
                            ]
                        );
                    }
                }
            }

            return response()->json(['message' => 'Pathao data stored successfully']);
        } catch (\Exception $e) {
            Log::error("Pathao Data Fetch Error: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch Pathao data'], 500);
        }
    }

    public function getStoredPathaoData()
    {
        $data = PathaoLocation::orderBy('city_name')->get();
        return response()->json($data);
    }

    private function getPathaoAccessToken()
    {
        $cachedToken = Cache::get('pathao_access_token');
        if ($cachedToken) {
            return $cachedToken;
        }

        $baseUrl = "https://api-hermes.pathao.com";
        $credentials = [
            "client_id" => config('pathao.client_id'),
            "client_secret" => config('pathao.client_secret'),
            "grant_type" => "password",
            "username" => config('pathao.username'),
            "password" => config('pathao.password'),
        ];

        try {
            $response = Http::post("$baseUrl/aladdin/api/v1/issue-token", $credentials);
            $data = $response->json();

            if (isset($data['access_token'])) {
                Cache::put('pathao_access_token', $data['access_token'], now()->addHours(23));
                return $data['access_token'];
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
