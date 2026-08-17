<?php

namespace App\Http\Controllers;

use App\Models\Signee;
use App\Services\AppleToken;
use App\Services\GeocodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function callback(string $provider, Request $request, GeocodeService $geocodeService, AppleToken $appleToken)
    {
        if ($provider === 'apple') {
            if (config('services.apple.private_key')) {
                try {
                    config()->set('services.apple.client_secret', app(AppleToken::class)->generate());
                } catch (\Exception $e) {
                    Log::warning("Failed to generate Apple client secret: " . $e->getMessage());
                }
            }
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            Log::error("Socialite callback failed for {$provider}: " . $e->getMessage(), [
                'exception' => $e,
            ]);
            return redirect('/')->with('error', 'Authentication failed.');
        }

        $ip = $request->ip();
        $location = $geocodeService->lookup($ip);

        $signee = Signee::firstOrNew(['email' => $socialUser->getEmail()]);
        
        $signee->fill(array_filter([
            'name' => $socialUser->getName() ?? $socialUser->getNickname(),
            'social_auth_type' => $provider,
            'ip_address' => $ip,
            'city' => $location['city'],
            'state' => $location['state'],
            'latitude' => $location['latitude'],
            'longitude' => $location['longitude'],
            'place_id' => $location['place_id'],
        ], fn($value) => $value !== null));

        if (empty($signee->alt_id) || !\Illuminate\Support\Str::isUuid($signee->alt_id)) {
            $signee->alt_id = (string) \Illuminate\Support\Str::uuid();
        }

        $signee->save();

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
