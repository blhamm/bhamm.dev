<?php

namespace App\Http\Controllers;

use App\Models\Signee;
use App\Services\AppleToken;
use App\Services\GeocodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Pennant\Feature;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        if (Feature::inactive("auth-{$provider}")) {
            return redirect('/')->with('error', "Authentication via {$provider} is currently unavailable.");
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider, Request $request, GeocodeService $geocodeService)
    {
        if ($provider === 'apple') {
            config(['services.apple.client_secret' => app(AppleToken::class)->generate()]);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error("Socialite callback failed for {$provider}: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect('/')->with('error', 'Authentication failed.');
        }

        $ip = $request->ip();
        $location = $geocodeService->lookup($ip);

        $socialName = $socialUser->getName() ?? $socialUser->getNickname();

        $signee = Signee::where('email', $socialUser->getEmail())->first();

        $attributes = array_filter([
            'social_auth_type' => $provider,
            'ip_address' => $ip,
        ], fn ($value) => $value !== null);

        if (! $signee) {
            $attributes['email'] = $socialUser->getEmail();
            $attributes['name'] = ! empty($socialName) ? $socialName : 'Anonymous';
            $signee = Signee::create($attributes);
        } else {
            if (! empty($socialName) && ($signee->name === 'Anonymous' || empty($signee->name))) {
                $attributes['name'] = $socialName;
            }
            $signee->update($attributes);
        }

        $locationData = array_filter([
            'city' => $location['city'] ?? null,
            'state' => $location['state'] ?? null,
            'country' => $location['country'] ?? null,
            'latitude' => $location['latitude'] ?? null,
            'longitude' => $location['longitude'] ?? null,
            'place_id' => $location['place_id'] ?? null,
        ], fn ($value) => $value !== null);

        if (! empty($locationData)) {
            $signee->location()->updateOrCreate([], $locationData);
        }

        if (empty($signee->alt_id)) {
            $signee->update(['alt_id' => (string) Str::uuid()]);
        }

        // Authenticate the signee
        Auth::guard('signee')->login($signee);

        // We redirect back to home with a parameter to trigger the Guestbook modal
        return redirect('/?guestbook=1&user_id='.$signee->alt_id);
    }

    public function logout(Request $request)
    {
        Auth::guard('signee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
