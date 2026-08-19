<?php

namespace App\Services;

use App\Contracts\GeocodingInterface;
use Geocodio\Geocodio;
use Illuminate\Support\Facades\Log;

class GeocodioGeocodingService implements GeocodingInterface
{
    /**
     * @return array<string, string|float|null> $items
     *                                          Geocode an address query using Geocodio API.
     */
    public function lookup(string $query): array
    {
        $defaultResult = [
            'city' => null,
            'state' => null,
            'country' => null,
            'latitude' => null,
            'longitude' => null,
            'place_id' => null,
        ];

        if (! config('geoip.geocoding_enabled')) {
            return $defaultResult;
        }

        $apiKey = config('services.geocodio.key');
        if (! $apiKey) {
            return $defaultResult;
        }

        try {
            $geocodio = new Geocodio;
            $geocodio->setApiKey($apiKey);
            $response = $geocodio->geocode($query);

            if (isset($response['results'][0]['response']['results'][0])) {
                $data = $response['results'][0]['response']['results'][0];
                $lat = $data['location']['lat'] ?? null;
                $lng = $data['location']['lng'] ?? null;
                $formattedAddress = $data['formatted_address'] ?? null;
                $components = $data['address_components'] ?? [];

                return [
                    'city' => $components['city'] ?? null,
                    'state' => $components['state'] ?? null,
                    'country' => $components['country'] ?? null,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'place_id' => $formattedAddress,
                ];
            }
        } catch (\Exception $e) {
            Log::warning("Geocodio lookup failed for query {$query}: ".$e->getMessage());
        }

        return $defaultResult;
    }

    /**
     * @param  array<string, string|null>|list<string>  $queries
     * @return array<string, mixed>
     *                              Batch geocode multiple queries.
     */
    public function batchGeocode(array $queries): array
    {
        if (empty($queries) || ! config('geoip.geocoding_enabled')) {
            return [];
        }

        $apiKey = config('services.geocodio.key');
        if (! $apiKey) {
            return [];
        }

        try {
            $geocodio = new Geocodio;
            $geocodio->setApiKey($apiKey);

            return $geocodio->geocode($queries);
        } catch (\Exception $e) {
            Log::error('Geocodio batch request failed: '.$e->getMessage());

            return [];
        }
    }
}
