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

    public function callback(string $provider, Request $request)
    {
        if ($provider === 'apple') {
            config(['services.apple.client_secret' => app(\App\Services\AppleToken::class)->generate()]);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Authentication failed.');
        }

        $user = Signee::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'social_auth_type' => $provider,
                'ip_address' => $request->ip(),
            ]
        );

        // Authenticate the signee
        Auth::guard('signee')->login($user);

        // We redirect back to home with a parameter to trigger the Guestbook modal
        return redirect('/?guestbook=1&user_id=' . $user->id);
    }

    public function logout(Request $request)
    {
        Auth::guard('signee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
