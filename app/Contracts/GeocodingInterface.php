<?php

namespace App\Contracts;

interface GeocodingInterface
{
    /**
     * Lookup or geocode location data for a query (IP address or address string).
     *
     * @return array<string, string|float|null>
     */
    public function lookup(string $query): array;
}
