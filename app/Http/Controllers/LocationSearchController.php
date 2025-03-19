<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PathaoLocation;
use Illuminate\Support\Facades\Log;

class LocationSearchController extends Controller
{
    /**
     * Match Barikoi API data with PathaoLocation database.
     */
    public function matchLocation(Request $request)
    {
        $city = $request->query('city');
        $area = $request->query('area');
        $district = $request->query('district');
        $address = $request->query('address'); // Full Address from Barikoi API

        if (!$area) {
            return response()->json(['error' => 'Area is required'], 400);
        }

        // ✅ Step 1: Normalize city, area, and district names (remove spaces & unnecessary words)
        $cleanedCity = self::normalizeText($city);
        $cleanedArea = self::normalizeText($area);
        $cleanedDistrict = self::normalizeText($district);

        // ✅ Step 2: Find the correct city in Pathao (ignoring spaces)
        $matchedCity = PathaoLocation::whereRaw("REPLACE(city_name, ' ', '') LIKE ?", ["%$cleanedCity%"])->first();

        if (!$matchedCity) {
            // ✅ If city is missing but exists as a zone, fetch the correct city
            $matchedZoneCity = PathaoLocation::whereRaw("REPLACE(zone_name, ' ', '') LIKE ?", ["%$cleanedCity%"])->first();
            if ($matchedZoneCity) {
                $cleanedCity = $matchedZoneCity->city_name;
            }
        }

        // ✅ Step 3: Find the best-matched city & district in Pathao (with space normalization)
        $matchedCityDistrict = PathaoLocation::whereRaw("REPLACE(city_name, ' ', '') LIKE ?", ["%$cleanedCity%"])
                                             ->whereRaw("REPLACE(zone_name, ' ', '') LIKE ?", ["%$cleanedDistrict%"])
                                             ->first();

        if (!$matchedCityDistrict) {
            return response()->json([
                'message' => 'No relevant match found for city & district',
                'matched' => false,
                'city_id' => null,
                'city' => $cleanedCity,
                'zone_id' => null,
                'zone' => null,
                'area_id' => null,
                'area' => null,
            ]);
        }

        // ✅ Step 4: Find the most relevant area match within the correct city & district
        $matchedArea = PathaoLocation::whereRaw("REPLACE(area_name, ' ', '') LIKE ?", ["%$cleanedArea%"])
                                     ->whereRaw("REPLACE(city_name, ' ', '') LIKE ?", ["%$matchedCityDistrict->city_name%"])
                                     ->first();

        if (!$matchedArea) {
            // ✅ Step 5: If no area match, try finding the zone based on cleaned area name
            $matchedZone = PathaoLocation::whereRaw("REPLACE(zone_name, ' ', '') LIKE ?", ["%$cleanedArea%"])
                                         ->whereRaw("REPLACE(city_name, ' ', '') LIKE ?", ["%$matchedCityDistrict->city_name%"])
                                         ->first();

            if (!$matchedZone) {
                // ✅ Step 6: Try Extracting Area from Address
                $potentialAreaFromAddress = self::extractRelevantAreaFromAddress($address, $matchedCityDistrict->zone_name);

                if ($potentialAreaFromAddress) {
                    return response()->json([
                        'message' => 'Matched using relevant keyword from Address',
                        'matched' => true,
                        'city_id' => $matchedCityDistrict->city_id,
                        'city' => $matchedCityDistrict->city_name,
                        'zone_id' => $matchedCityDistrict->zone_id,
                        'zone' => $matchedCityDistrict->zone_name,
                        'area_id' => null,
                        'area' => $potentialAreaFromAddress,
                    ]);
                }

                // ❌ Step 7: No relevant match, return only zone & city (area is null)
                return response()->json([
                    'message' => 'No relevant area match found, sending best-matched Zone & City',
                    'matched' => true,
                    'city_id' => $matchedCityDistrict->city_id,
                    'city' => $matchedCityDistrict->city_name,
                    'zone_id' => $matchedCityDistrict->zone_id,
                    'zone' => $matchedCityDistrict->zone_name,
                    'area_id' => null,
                    'area' => null,
                ]);
            }

            // ✅ Step 8: If Matched in Zone, Return Zone with `null` Area
            return response()->json([
                'message' => 'Matched using Zone Name instead of Area',
                'matched' => true,
                'city_id' => $matchedZone->city_id,
                'city' => $matchedZone->city_name,
                'zone_id' => $matchedZone->zone_id,
                'zone' => $matchedZone->zone_name,
                'area_id' => null,
                'area' => null,
            ]);
        }

        // ✅ Step 9: Return Best Matched Area & Zone
        return response()->json([
            'message' => 'Best match found',
            'matched' => true,
            'city_id' => $matchedArea->city_id,
            'city' => $matchedArea->city_name,
            'zone_id' => $matchedArea->zone_id,
            'zone' => $matchedArea->zone_name,
            'area_id' => $matchedArea->area_id,
            'area' => $matchedArea->area_name,
        ]);
    }

    /**
     * Normalize text: Removes spaces, converts to lowercase, and trims the text.
     */
    private static function normalizeText($input)
    {
        return strtolower(str_replace(' ', '', trim($input)));
    }

    /**
     * Extract relevant area from address using fuzzy keyword matching.
     */
    private static function extractRelevantAreaFromAddress($address, $zoneName)
    {
        $addressParts = explode(',', $address);

        foreach ($addressParts as $part) {
            $trimmedPart = trim($part);
            $normalizedPart = self::normalizeText($trimmedPart);

            $matchedArea = PathaoLocation::whereRaw("REPLACE(area_name, ' ', '') LIKE ?", ["%$normalizedPart%"])
                                         ->whereRaw("REPLACE(zone_name, ' ', '') LIKE ?", ["%$zoneName%"])
                                         ->first();

            if ($matchedArea) {
                return $matchedArea->area_name;
            }
        }

        return null;
    }
}
