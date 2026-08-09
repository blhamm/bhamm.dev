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
        if ($request->has('guestbook') && $request->has('user_id')) {
            $guard = Auth::guard('signee');
            
            if (!app()->isLocal() && (!$guard->check() || $guard->id() != $request->query('user_id'))) {
                return redirect()->route('home');
            }
        }

        return view('welcome');
    }
}
