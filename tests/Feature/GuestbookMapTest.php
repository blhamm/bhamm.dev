<?php

use App\Models\Signee;
use App\Models\Visitor;
use Illuminate\Support\Facades\Cache;
use Laravel\Pennant\Feature;
use Livewire\Livewire;

beforeEach(function () {
    Cache::flush();
});

test('guestbook map caches points for 5 minutes', function () {
    Feature::activate('guestbook-signees');

    $signee = Signee::create([
        'name' => 'Alice Allison',
        'email' => 'alice@example.com',
        'social_auth_type' => 'github',
        'message' => 'Hello from Alice',
        'private' => false,
    ]);
    $signee->location()->create([
        'latitude' => 30.2672,
        'longitude' => -97.7431,
        'city' => 'Austin',
        'state' => 'TX',
    ]);

    $visitor = Visitor::create([
        'ip_address' => '198.51.100.10',
        'last_seen_at' => now(),
    ]);
    $visitor->location()->create([
        'latitude' => 37.7749,
        'longitude' => -122.4194,
        'city' => 'San Francisco',
        'state' => 'CA',
    ]);

    // Initial mount populates cache
    $component = Livewire::test('guestbook-map');
    $initialPoints = $component->viewData('points');

    expect($initialPoints)->toHaveCount(2)
        ->and(Cache::has('guestbook_map_points_with_signees'))->toBeTrue();

    // Create a new visitor in the database
    $newVisitor = Visitor::create([
        'ip_address' => '198.51.100.20',
        'last_seen_at' => now(),
    ]);
    $newVisitor->location()->create([
        'latitude' => 40.7128,
        'longitude' => -74.0060,
        'city' => 'New York',
        'state' => 'NY',
    ]);

    // Subscribing / rendering within cache window serves cached data
    $cachedComponent = Livewire::test('guestbook-map');
    expect($cachedComponent->viewData('points'))->toHaveCount(2);

    // After 5 minutes, cache expires and returns updated points
    $this->travel(6)->minutes();
    $freshComponent = Livewire::test('guestbook-map');
    expect($freshComponent->viewData('points'))->toHaveCount(3);
});

test('guestbook-signed event clears cached map points and refreshes data', function () {
    Feature::activate('guestbook-signees');

    $visitor = Visitor::create([
        'ip_address' => '198.51.100.30',
        'last_seen_at' => now(),
    ]);
    $visitor->location()->create([
        'latitude' => 51.5074,
        'longitude' => -0.1278,
        'city' => 'London',
    ]);

    $component = Livewire::test('guestbook-map');
    expect($component->viewData('points'))->toHaveCount(1)
        ->and(Cache::has('guestbook_map_points_with_signees'))->toBeTrue();

    // Add a new visitor in DB while cache is warm
    $newVisitor = Visitor::create([
        'ip_address' => '198.51.100.31',
        'last_seen_at' => now(),
    ]);
    $newVisitor->location()->create([
        'latitude' => 48.8566,
        'longitude' => 2.3522,
        'city' => 'Paris',
    ]);

    // Calling the component without event still returns cached 1 point
    expect(Livewire::test('guestbook-map')->viewData('points'))->toHaveCount(1);

    // Calling refreshMap (or dispatching guestbook-signed) invalidates the cache and re-queries
    $component->call('refreshMap');
    expect($component->viewData('points'))->toHaveCount(2);
});

test('guestbook map segments cache by feature flag state', function () {
    Feature::deactivate('guestbook-signees');

    $signee = Signee::create([
        'name' => 'Bob Builder',
        'email' => 'bob@example.com',
        'social_auth_type' => 'github',
        'message' => 'Can we fix it?',
        'private' => false,
    ]);
    $signee->location()->create([
        'latitude' => 34.0522,
        'longitude' => -118.2437,
    ]);

    $component = Livewire::test('guestbook-map');

    expect(Cache::has('guestbook_map_points_without_signees'))->toBeTrue()
        ->and(Cache::has('guestbook_map_points_with_signees'))->toBeFalse()
        ->and($component->viewData('points'))->toHaveCount(0);

    Feature::activate('guestbook-signees');

    $componentWithFeature = Livewire::test('guestbook-map');
    expect(Cache::has('guestbook_map_points_with_signees'))->toBeTrue()
        ->and($componentWithFeature->viewData('points'))->toHaveCount(1);
});
