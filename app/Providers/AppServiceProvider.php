<?php

namespace App\Providers;

use App\Services\AppleToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use SocialiteProviders\Apple\Provider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('apple', Provider::class);
        });

        $this->defineFeatures();

		$this->app->bind(Configuration::class, function () {
            $key = config('services.apple.private_key') ?? '';

            if ($key && !str_starts_with($key, '-----BEGIN')) {
                $decoded = base64_decode($key);
                if ($decoded !== false) {
                    $key = $decoded;
                }
            }

            return Configuration::forSymmetricSigner(
                new Sha256(),
                InMemory::plainText($key),
            );
        });
    }

    protected function defineFeatures(): void
    {
        $features = config('pennant.features', []);

        foreach ($features as $feature) {
            Feature::define($feature, function ($user) {
                if (session('preview_mode') === true) {
                    return true;
                }

                $user = $user ?? Auth::guard('signee')->user();

                if ($user && in_array($user->email, config('services.pennant.allow_list', []))) {
                    return true;
                }

                return false;
            });
        }
    }
}
