<?php

namespace App\Http\Controllers;

use App\Models\Signee;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View|RedirectResponse
    {
        // Guard guestbook form access
        if ($request->has('guestbook') && $request->has('alt_id')) {
            $guard = Auth::guard('signee');
            $identifier = $request->query('alt_id');
            $user = Signee::where('alt_id', $identifier)->first();

            if (! app()->isLocal() && (! $guard->check() || ! $user || $guard->id() !== $user->id)) {
                return redirect()->route('home');
            }
        }

        return view('welcome');
    }
}
