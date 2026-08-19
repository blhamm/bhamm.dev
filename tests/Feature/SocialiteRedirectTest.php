<?php

use App\Models\Signee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;

uses(RefreshDatabase::class);

it('redirects to home with alt_id uuid on socialite callback success', function () {
    $socialUser = Mockery::mock(User::class);
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
        ->and($redirectUrl)->toContain('user_id='.$signee->alt_id)
        ->and($redirectUrl)->not->toContain('user_id='.$signee->id);
});
