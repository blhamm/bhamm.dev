<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureVisitorIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('geoip.track_visitors')) {
            $ip = $request->ip();
            
            if ($ip) {
                Visitor::updateOrCreate(
                    ['ip_address' => $ip],
                    ['last_seen_at' => now()]
                );
            }
        }

        return $next($request);
    }
}
