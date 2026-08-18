<?php

use App\Models\Signee;
use Illuminate\Support\Facades\Auth;
use Laravel\Pennant\Feature;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Livewire;

test('socialite redirect redirects to provider when feature is active', function () {
    Feature::activate('auth-github');

    $response = $this->get('/auth/github/redirect');

    $response->assertRedirect();
    expect($response->getTargetUrl())->toContain('github.com/login/oauth/authorize');
});

test('socialite redirect redirects to home with error when feature is inactive', function () {
    Feature::forget('auth-github');

    $response = $this->get('/auth/github/redirect');

    $response->assertRedirect('/');
    $response->assertSessionHas('error', 'Authentication via github is currently unavailable.');
});

test('socialite callback handles exception gracefully and redirects with error', function () {
    Socialite::shouldReceive('driver->user')->andThrow(new \Exception('OAuth error'));

    $response = $this->get('/auth/github/callback');

    $response->assertRedirect('/');
    $response->assertSessionHas('error', 'Authentication failed.');
});

test('signout logs out signee and invalidates session', function () {
    $signee = Signee::create([
        'name' => 'Logout User',
        'email' => 'logout@example.com',
        'social_auth_type' => 'github',
    ]);

    Auth::guard('signee')->login($signee);
    expect(Auth::guard('signee')->check())->toBeTrue();

    $response = $this->post('/auth/logout');

    $response->assertRedirect('/');
    expect(Auth::guard('signee')->check())->toBeFalse();
});

test('guestbook form mounts successfully and validates message requirement', function () {
    $signee = Signee::create([
        'name' => 'Guestbook User',
        'email' => 'guestbook@example.com',
        'social_auth_type' => 'github',
    ]);

    Auth::guard('signee')->login($signee);

    Livewire::test('guestbook-form', ['userId' => $signee->alt_id])
        ->set('message', '')
        ->call('save')
        ->assertHasErrors(['message' => 'required']);
});

test('guestbook form updates message and toggles privacy successfully', function () {
    $signee = Signee::create([
        'name' => 'Privacy User',
        'email' => 'privacy@example.com',
        'social_auth_type' => 'github',
        'message' => 'Old message',
        'private' => false,
    ]);

    Auth::guard('signee')->login($signee);

    Livewire::test('guestbook-form', ['userId' => $signee->alt_id])
        ->set('message', 'Hello from updated test message!')
        ->set('private', true)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect('/#guestbook');

    $signee->refresh();

    expect($signee->message)
	    ->toBe('Hello from updated test message!')
	    ->and($signee->private)->toBeTrue();
});

test('guestbook form displays city and state location when present', function () {
    $signee = Signee::create([
        'name' => 'Geocoded User',
        'email' => 'geo@example.com',
        'social_auth_type' => 'github',
        'city' => 'Austin',
        'state' => 'TX',
    ]);

    Auth::guard('signee')->login($signee);

    Livewire::test('guestbook-form', ['userId' => $signee->alt_id])
        ->assertSee('Austin, TX');
});

test('signee defaults to anonymous when name is not provided', function () {
    $signee = Signee::create([
        'email' => 'anon@example.com',
        'social_auth_type' => 'github',
    ]);

    expect($signee->name)->toBe('Anonymous')
        ->and($signee->display_name)->toBe('Anonymous')
        ->and($signee->first_name)->toBe('Anonymous');
});

test('guestbook form displays optional name input for anonymous signee and allows updating name', function () {
    $signee = Signee::create([
        'name' => 'Anonymous',
        'email' => 'anonform@example.com',
        'social_auth_type' => 'github',
    ]);

    Auth::guard('signee')->login($signee);

    Livewire::test('guestbook-form', ['userId' => $signee->alt_id])
        ->assertSee('Your Name (Optional)')
        ->set('message', 'Hello from anonymous user!')
        ->set('name', 'John Doe')
        ->call('save')
        ->assertHasNoErrors();

    $signee->refresh();
    expect($signee->name)->toBe('John Doe')
        ->and($signee->display_name)->toBe('John D.');
});
