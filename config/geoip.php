<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Visitor Tracking
    |--------------------------------------------------------------------------
    |
    | This option controls whether the application will record the IP addresses
    | of site visitors in the `visitors` table.
    |
    */
    'track_visitors' => env('GEOIP_TRACK_VISITORS', true),

    /*
    |--------------------------------------------------------------------------
    | Geocoding
    |--------------------------------------------------------------------------
    |
    | This option controls whether the application will perform batch geocoding
    | for Signees and Visitors via the `geoip:geocode` Artisan command.
    |
    */
    'geocoding_enabled' => env('GEOIP_GEOCODING_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | MaxMind Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the local MaxMind GeoLite2 City database.
    |
    */
    'maxmind' => [
		'account_id' => env('MAXMIND_ACCOUNT_ID'),
	    'license_key' => env('MAXMIND_LICENSE_KEY'),
        'database_path' => database_path('geoip/GeoLite2-City.mmdb'),
        'download_url' => 'https://download.maxmind.com/geoip/databases/GeoLite2-City/download?suffix=tar.gz',
    ],
];
