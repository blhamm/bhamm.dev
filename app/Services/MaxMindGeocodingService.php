<?php

namespace App\Services;

use App\Contracts\GeocodingInterface;
use GeoIp2\Database\Reader;
use Illuminate\Support\Facades\Log;

class MaxMindGeocodingService implements GeocodingInterface
{
    /**
     * Lookup location data for an IP address using MaxMind GeoIP2.
     *
     * @param string|null $query IP address
     * @return array
     */
    public function lookup(?string $query): array
    {
        $defaultResult = [
            'city' => null,
            'state' => null,
            'country' => null,
            'latitude' => null,
            'longitude' => null,
            'place_id' => null,
        ];

        if (!config('geoip.geocoding_enabled')) {
            return $defaultResult;
        }

        $dbPath = config('geoip.maxmind.database_path');
        if (!file_exists($dbPath)) {
            return $defaultResult;
        }

        try {
            $reader = new Reader($dbPath);
            $lookupIp = ($query === '127.0.0.1' || !$query) ? '8.8.8.8' : $query;
            $recordData = $reader->city($lookupIp);

            $city = $recordData->city->name ?? null;
            $state = $recordData->mostSpecificSubdivision->isoCode ?? null;
            $country = $recordData->country->name ?? null;
            $latitude = $recordData->location->latitude ?? null;
            $longitude = $recordData->location->longitude ?? null;

            $placeId = null;
            if ($city && $state) {
                $placeId = "{$city}, {$state}";
            } elseif ($city) {
                $placeId = $city;
            }

            return [
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'place_id' => $placeId,
            ];
        } catch (\Exception $e) {
            Log::warning("MaxMind lookup failed for IP {$query}: " . $e->getMessage());
            return $defaultResult;
        }
    }
}
