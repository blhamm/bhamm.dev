<?php

use App\Models\Signee;
use Laravel\Socialite\Facades\Socialite;

it('redirects to home with alt_id uuid on socialite callback success', function () {
    $socialUser = Mockery::mock(\Laravel\Socialite\Two\User::class);
    $socialUser->shouldReceive('getEmail')->andReturn('test@example.com');
    $socialUser->shouldReceive('getName')->andReturn('Test User');

    Socialite::shouldReceive('driver->user')->andReturn($socialUser);

    $response = $this->get('/auth/github/callback');

    $response->assertRedirect();
    $redirectUrl = $response->headers->get('Location');

    expect($redirectUrl)->toContain('guestbook=1');

    $signee = Signee::where('email', 'test@example.com')->first();
    expect($signee)->not->toBeNull()
	    ->and($signee->alt_id)->not->toBeNull()
	    ->and($redirectUrl)->toContain('user_id=' . $signee->alt_id)
	    ->and($redirectUrl)->not->toContain('user_id=' . $signee->id);
});

it('redirects to home with alt_id uuid on apple post socialite callback success', function () {
    $socialUser = Mockery::mock(\Laravel\Socialite\Two\User::class);
    $socialUser->shouldReceive('getEmail')->andReturn('apple-test@example.com');
    $socialUser->shouldReceive('getName')->andReturn('Apple User');

    Socialite::shouldReceive('driver->user')->andReturn($socialUser);

    $response = $this->post('/auth/apple/callback', [
        'id_token' => 'mock-id-token',
        'code' => 'mock-code',
    ]);

    $response->assertRedirect();
    $redirectUrl = $response->headers->get('Location');

    expect($redirectUrl)->toContain('guestbook=1');

    $signee = Signee::where('email', 'apple-test@example.com')->first();
    expect($signee)->not->toBeNull()
	    ->and($signee->alt_id)->not->toBeNull()
	    ->and($signee->social_auth_type)->toBe('apple')
	    ->and($redirectUrl)->toContain('user_id=' . $signee->alt_id);
});
