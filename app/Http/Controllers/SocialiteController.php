<?php

namespace App\Http\Controllers;

use App\Models\Signee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function callback(string $provider, Request $request, \App\Services\GeocodeService $geocodeService)
    {
        if ($provider === 'apple') {
            config(['services.apple.client_secret' => app(\App\Services\AppleToken::class)->generate()]);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Socialite callback failed for {$provider}: " . $e->getMessage(), [
                'exception' => $e,
            ]);
            return redirect('/')->with('error', 'Authentication failed.');
        }

        $ip = $request->ip();
        $location = $geocodeService->lookup($ip);

        $signee = Signee::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            array_filter([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'social_auth_type' => $provider,
                'ip_address' => $ip,
                'city' => $location['city'],
                'state' => $location['state'],
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
                'place_id' => $location['place_id'],
            ], fn($value) => $value !== null)
        );

        if (empty($signee->alt_id)) {
            $signee->update(['alt_id' => (string) \Illuminate\Support\Str::uuid()]);
        }

        // Authenticate the signee
        Auth::guard('signee')->login($signee);

        // We redirect back to home with a parameter to trigger the Guestbook modal
        return redirect('/?guestbook=1&user_id=' . $signee->alt_id);
    }

    public function logout(Request $request)
    {
        Auth::guard('signee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
