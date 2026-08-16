<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use App\Services\GeocodeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureVisitorIp
{
    public function __construct(
        protected GeocodeService $geocode
    ) {}

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
				$visitor = Visitor::updateOrCreate(
                    ['ip_address' => $ip],
                    ['last_seen_at' => now()]
                );

				if ($visitor->wasRecentlyCreated) {
					$location = $this->geocode->lookup($ip);

					$visitor->update([
						'city' => $location['city'],
	                    'state' => $location['state'],
						'latitude' => $location['latitude'],
						'longitude' => $location['longitude'],
                        'country' => $location['country'],
					]);
				}
            }
        }

        return $next($request);
    }
}
