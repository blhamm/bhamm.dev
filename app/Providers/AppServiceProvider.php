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
            $key = trim($key, "\"'");
            $key = str_replace(['\n', '\\n'], "\n", $key);

            if ($key && !str_starts_with($key, '-----BEGIN')) {
                $decoded = base64_decode($key, true);
                if ($decoded !== false) {
                    $key = trim($decoded, "\"'");
                    $key = str_replace(['\n', '\\n'], "\n", $key);
                }
            }

            if ($key && (str_contains($key, 'BEGIN EC PRIVATE KEY') || str_contains($key, 'BEGIN PRIVATE KEY'))) {
                $descriptors = [
                    0 => ['pipe', 'r'],
                    1 => ['pipe', 'w'],
                    2 => ['pipe', 'w'],
                ];
                $process = @proc_open('openssl pkey -outform PEM', $descriptors, $pipes);
                if (is_resource($process)) {
                    fwrite($pipes[0], $key);
                    fclose($pipes[0]);
                    $converted = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);
                    fclose($pipes[2]);
                    if (proc_close($process) === 0 && !empty($converted)) {
                        $key = $converted;
                    }
                }
            }

            $privateKeyResource = @openssl_pkey_get_private($key);
            if ($privateKeyResource === false) {
                $descriptors = [
                    0 => ['pipe', 'r'],
                    1 => ['pipe', 'w'],
                    2 => ['pipe', 'w'],
                ];
                $process = @proc_open('openssl pkcs8 -nocrypt -outform PEM', $descriptors, $pipes);
                if (is_resource($process)) {
                    fwrite($pipes[0], $key);
                    fclose($pipes[0]);
                    $converted = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);
                    fclose($pipes[2]);
                    if (proc_close($process) === 0 && !empty($converted)) {
                        $key = $converted;
                    }
                }
                $privateKeyResource = @openssl_pkey_get_private($key);
            }

            if ($privateKeyResource === false) {
                $error = '';
                while ($msg = openssl_error_string()) {
                    $error .= PHP_EOL . '* ' . $msg;
                }
                throw \Lcobucci\JWT\Signer\InvalidKeyProvided::cannotBeParsed($error);
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
