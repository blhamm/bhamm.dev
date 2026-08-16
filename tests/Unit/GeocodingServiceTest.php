<?php

use App\Contracts\GeocodingInterface;
use App\Services\GeocodeService;
use App\Services\GeocodioGeocodingService;
use App\Services\MaxMindGeocodingService;
use Tests\TestCase;

uses(TestCase::class);

test('geocoding services implement GeocodingInterface', function () {
    expect(app(MaxMindGeocodingService::class))->toBeInstanceOf(GeocodingInterface::class)
	    ->and(app(GeocodioGeocodingService::class))->toBeInstanceOf(GeocodingInterface::class)
	    ->and(app(GeocodeService::class))->toBeInstanceOf(GeocodingInterface::class);
});

test('geocode service delegates lookup to maxmind service', function () {
    config(['geoip.geocoding_enabled' => false]);

    $service = app(GeocodeService::class);
    $result = $service->lookup('127.0.0.1');

    expect($result)->toHaveKeys(['city', 'state', 'country', 'latitude', 'longitude', 'place_id'])
        ->and($result['city'])->toBeNull();
});

test('geocodio service returns default result when geocoding is disabled or api key is missing', function () {
    config(['geoip.geocoding_enabled' => false]);

    $geocodio = app(GeocodioGeocodingService::class);
    $result = $geocodio->lookup('Austin, TX');

    expect($result)->toHaveKeys(['city', 'state', 'country', 'latitude', 'longitude', 'place_id'])
        ->and($result['city'])->toBeNull();
});
