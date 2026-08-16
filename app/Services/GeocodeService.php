<?php

namespace App\Services;

use App\Contracts\GeocodingInterface;

class GeocodeService implements GeocodingInterface
{
    public function __construct(
        protected MaxMindGeocodingService $maxMindService,
        protected GeocodioGeocodingService $geocodioService
    ) {}

    /**
     * Lookup location data for an IP address or query.
     *
     * @param string|null $query
     * @return array
     */
    public function lookup(?string $query): array
    {
        return $this->maxMindService->lookup($query);
    }

    /**
     * Get the underlying MaxMind service.
     */
    public function maxMind(): MaxMindGeocodingService
    {
        return $this->maxMindService;
    }

    /**
     * Get the underlying Geocodio service.
     */
    public function geocodio(): GeocodioGeocodingService
    {
        return $this->geocodioService;
    }
}
