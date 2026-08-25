<?php

use App\Http\Middleware\CaptureVisitorIp;
use App\Models\Location;
use App\Models\Visitor;
use App\Services\GeocodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    config([
        'geoip.track_visitors' => true,
        'geoip.geocoding_enabled' => false,
    ]);
});

test('captures visitor ip and creates location on terminate', function () {
    $geocodeMock = mock(GeocodeService::class);
    $geocodeMock->shouldReceive('lookup')
        ->with('198.51.100.1')
        ->once()
        ->andReturn([
            'city' => 'Austin',
            'state' => 'TX',
            'country' => 'United States',
            'latitude' => 30.2672,
            'longitude' => -97.7431,
            'place_id' => 'Austin, TX',
        ]);

    $middleware = new CaptureVisitorIp($geocodeMock);

    $request = Request::create('/', 'GET', server: ['REMOTE_ADDR' => '198.51.100.1']);
    $response = new Response;

    $middleware->handle($request, fn ($req) => $response);
    $middleware->terminate($request, $response);

    $visitor = Visitor::where('ip_address', '198.51.100.1')->first();
    expect($visitor)->not->toBeNull()
        ->and($visitor->location)->not->toBeNull()
        ->and($visitor->city)->toBe('Austin')
        ->and($visitor->state)->toBe('TX')
        ->and($visitor->country)->toBe('United States')
        ->and($visitor->latitude)->toBe(30.2672)
        ->and($visitor->longitude)->toBe(-97.7431);
});

test('debounces repeated requests from the same IP within cache ttl', function () {
    $geocodeMock = mock(GeocodeService::class);
    $geocodeMock->shouldReceive('lookup')
        ->with('198.51.100.2')
        ->once()
        ->andReturn([
            'city' => 'Dallas',
            'state' => 'TX',
            'country' => 'United States',
            'latitude' => 32.7767,
            'longitude' => -96.7970,
            'place_id' => 'Dallas, TX',
        ]);

    $middleware = new CaptureVisitorIp($geocodeMock);

    $request = Request::create('/', 'GET', server: ['REMOTE_ADDR' => '198.51.100.2']);
    $response = new Response;

    // First request records visitor
    $middleware->terminate($request, $response);

    $visitor = Visitor::where('ip_address', '198.51.100.2')->first();
    $lastSeenAt = $visitor->last_seen_at;

    // Second request within cache ttl should be skipped (no geocode call, no last_seen_at change)
    $middleware->terminate($request, $response);

    $visitor->refresh();
    expect($visitor->last_seen_at->toIso8601String())->toBe($lastSeenAt->toIso8601String())
        ->and(Visitor::where('ip_address', '198.51.100.2')->count())->toBe(1)
        ->and(Location::where('locationable_id', $visitor->id)->count())->toBe(1);
});

test('updates last_seen_at when cache key expires without duplicating location', function () {
    $geocodeMock = mock(GeocodeService::class);
    $geocodeMock->shouldReceive('lookup')
        ->with('198.51.100.3')
        ->once()
        ->andReturn([
            'city' => 'Houston',
            'state' => 'TX',
            'country' => 'United States',
            'latitude' => 29.7604,
            'longitude' => -95.3698,
            'place_id' => 'Houston, TX',
        ]);

    $middleware = new CaptureVisitorIp($geocodeMock);

    $request = Request::create('/', 'GET', server: ['REMOTE_ADDR' => '198.51.100.3']);
    $response = new Response;

    $middleware->terminate($request, $response);

    $visitor = Visitor::where('ip_address', '198.51.100.3')->first();
    $firstSeenAt = $visitor->last_seen_at;

    // Advance time past the 15-minute cache debounce window
    $this->travel(20)->minutes();

    // Second request after cache expiration should update last_seen_at without duplicate locations or geocode lookup
    $middleware->terminate($request, $response);

    $visitor->refresh();
    expect($visitor->last_seen_at->gt($firstSeenAt))->toBeTrue()
        ->and(Visitor::where('ip_address', '198.51.100.3')->count())->toBe(1)
        ->and(Location::where('locationable_id', $visitor->id)->count())->toBe(1);
});

test('does not record visitors when tracking is disabled', function () {
    config(['geoip.track_visitors' => false]);

    $geocodeMock = mock(GeocodeService::class);
    $geocodeMock->shouldNotReceive('lookup');

    $middleware = new CaptureVisitorIp($geocodeMock);

    $request = Request::create('/', 'GET', server: ['REMOTE_ADDR' => '198.51.100.4']);
    $response = new Response;

    $middleware->terminate($request, $response);

    expect(Visitor::where('ip_address', '198.51.100.4')->exists())->toBeFalse();
});

test('works properly with database cache driver', function () {
    config(['cache.default' => 'database']);

    $geocodeMock = mock(GeocodeService::class);
    $geocodeMock->shouldReceive('lookup')
        ->with('198.51.100.5')
        ->once()
        ->andReturn([
            'city' => 'Seattle',
            'state' => 'WA',
            'country' => 'United States',
            'latitude' => 47.6062,
            'longitude' => -122.3321,
            'place_id' => 'Seattle, WA',
        ]);

    $middleware = new CaptureVisitorIp($geocodeMock);

    $request = Request::create('/', 'GET', server: ['REMOTE_ADDR' => '198.51.100.5']);
    $response = new Response;

    $middleware->terminate($request, $response);

    expect(Visitor::where('ip_address', '198.51.100.5')->exists())->toBeTrue()
        ->and(Cache::has('visitor_seen:198.51.100.5'))->toBeTrue();

    // Second request is debounced via database cache driver
    $middleware->terminate($request, $response);

    expect(Visitor::where('ip_address', '198.51.100.5')->count())->toBe(1);
});
