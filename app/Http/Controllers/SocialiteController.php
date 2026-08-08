<?php

namespace App\Http\Controllers;

use App\Models\GuestBookUser;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Geocodio\Geocodio;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider, Request $request)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Authentication failed.');
        }

        $user = GuestBookUser::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'social_auth_type' => $provider,
            ]
        );

        // Geocoding logic
        if (!$user->lat || !$user->long) {
            $this->geocodeUser($user, $request->ip());
        }

        // We redirect back to home with a parameter to trigger the Guestbook modal
        return redirect('/?guestbook=1&user_id=' . $user->id);
    }

    protected function geocodeUser(GuestBookUser $user, string $ip)
    {
        // For local development, $ip might be 127.0.0.1. We use a fallback for testing.
        if ($ip === '127.0.0.1') {
            $ip = '8.8.8.8'; // Mountain View, CA
        }

        try {
            $geocodio = new Geocodio();
            $geocodio->setApiKey(config('services.geocodio.key'));

            // The PHP library returns an array
            $response = $geocodio->geocode($ip);
            
            if (!empty($response['results'])) {
                $result = $response['results'][0];
                $user->update([
                    'lat' => $result['location']['lat'],
                    'long' => $result['location']['lng'],
                    'place_id' => $result['formatted_address'],
                ]);
            }
        } catch (\Exception $e) {
            // Log error or handle silently
        }
    }
}
