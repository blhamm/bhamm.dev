<?php

namespace App\Http\Controllers;

use App\Models\Signee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
}
