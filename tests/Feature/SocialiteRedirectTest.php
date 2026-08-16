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

it('normalizes pkcs1 private key and generates apple jwt token successfully', function () {
    $res = openssl_pkey_new([
        "private_key_type" => OPENSSL_KEYTYPE_EC,
        "curve_name" => "prime256v1",
    ]);
    openssl_pkey_export($res, $pkcs8);

    $descriptors = [
        0 => ["pipe", "r"],
        1 => ["pipe", "w"],
        2 => ["pipe", "w"],
    ];
    $process = proc_open("openssl ec -outform PEM", $descriptors, $pipes);
    fwrite($pipes[0], $pkcs8);
    fclose($pipes[0]);
    $pkcs1 = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);

    config([
        'services.apple.team_id' => 'TESTTEAMID',
        'services.apple.client_id' => 'com.example.client',
        'services.apple.key_id' => 'TESTKEYID',
        'services.apple.private_key' => base64_encode($pkcs1),
    ]);

    app()->forgetInstance(\Lcobucci\JWT\Configuration::class);

    $appleToken = app(\App\Services\AppleToken::class);
    $tokenString = $appleToken->generate();

    expect($tokenString)->toBeString()->not->toBeEmpty();
});
