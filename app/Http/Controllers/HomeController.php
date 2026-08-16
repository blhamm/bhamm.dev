<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Guard guestbook form access
        if ($request->has('guestbook') && ($request->has('user_id') || $request->has('alt_id'))) {
            $guard = Auth::guard('signee');
            $identifier = $request->query('alt_id') ?? $request->query('user_id');
            $user = \App\Models\Signee::where('alt_id', $identifier)->orWhere('id', $identifier)->first();
            
            if (!app()->isLocal() && (!$guard->check() || !$user || $guard->id() !== $user->id)) {
                return redirect()->route('home');
            }
        }

        return view('welcome');
    }
}
