<?php

namespace App\Contracts;

interface GeocodingInterface
{
    /**
     * Lookup or geocode location data for a query (IP address or address string).
     *
     * @param string $query
     * @return array
     */
    public function lookup(string $query): array;
}
