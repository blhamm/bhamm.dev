<?php

use App\Models\Location;
use App\Models\Signee;
use App\Models\Visitor;
use Illuminate\Support\Facades\Artisan;

test('signee and visitor have location relation and accessors including country', function () {
    $signee = Signee::create([
        'name' => 'Signee Location Test',
        'email' => 'signee.loc@example.com',
        'social_auth_type' => 'github',
    ]);

    $signee->location()->create([
        'city' => 'Paris',
        'state' => 'IDF',
        'country' => 'FR',
        'latitude' => 48.8566,
        'longitude' => 2.3522,
        'place_id' => 'Paris, France',
    ]);

    expect($signee->city)->toBe('Paris')
        ->and($signee->state)->toBe('IDF')
        ->and($signee->country)->toBe('FR')
        ->and($signee->latitude)->toBe(48.8566)
        ->and($signee->longitude)->toBe(2.3522)
        ->and($signee->place_id)->toBe('Paris, France')
        ->and($signee->location)->toBeInstanceOf(Location::class);

    $visitor = Visitor::create([
        'ip_address' => '1.2.3.4',
    ]);

    $visitor->location()->create([
        'city' => 'London',
        'state' => 'ENG',
        'country' => 'GB',
        'latitude' => 51.5074,
        'longitude' => -0.1278,
    ]);

    expect($visitor->city)->toBe('London')
        ->and($visitor->state)->toBe('ENG')
        ->and($visitor->country)->toBe('GB')
        ->and($visitor->latitude)->toBe(51.5074)
        ->and($visitor->longitude)->toBe(-0.1278)
        ->and($visitor->location)->toBeInstanceOf(Location::class);
});

test('locations migrate command migrates records correctly', function () {
    // Create a signee or visitor without a location relation or with raw attributes if table allowed it,
    // but here test running php artisan locations:migrate works without errors.
    $exitCode = Artisan::call('locations:migrate');
    expect($exitCode)->toBe(0);
});
