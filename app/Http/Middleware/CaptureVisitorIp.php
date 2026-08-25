<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use App\Services\GeocodeService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CaptureVisitorIp
{
    public function __construct(
        protected GeocodeService $geocode
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Perform any final actions for the request lifecycle after response has been sent.
     */
    public function terminate(Request $request, Response $response): void
    {
        if (! config('geoip.track_visitors')) {
            return;
        }

        $ip = $request->ip();

        if (! $ip) {
            return;
        }

        if (! Cache::add("visitor_seen:{$ip}", true, now()->addMinutes(15))) {
            return;
        }

        $this->recordVisitor($ip);
    }

    /**
     * Record visitor activity and sync location if needed.
     */
    protected function recordVisitor(string $ip): void
    {
        $visitor = Visitor::with('location')->firstWhere('ip_address', $ip);

        if (! $visitor) {
            $locationData = $this->geocode->lookup($ip);

            $visitor = Visitor::create([
                'ip_address' => $ip,
                'last_seen_at' => now(),
            ]);

            $visitor->location()->create([
                'city' => $locationData['city'] ?? null,
                'state' => $locationData['state'] ?? null,
                'country' => $locationData['country'] ?? null,
                'latitude' => $locationData['latitude'] ?? null,
                'longitude' => $locationData['longitude'] ?? null,
                'place_id' => $locationData['place_id'] ?? null,
            ]);

            return;
        }

        $visitor->update([
            'last_seen_at' => now(),
        ]);

        if (! $visitor->location) {
            $locationData = $this->geocode->lookup($ip);

            $visitor->location()->create([
                'city' => $locationData['city'] ?? null,
                'state' => $locationData['state'] ?? null,
                'country' => $locationData['country'] ?? null,
                'latitude' => $locationData['latitude'] ?? null,
                'longitude' => $locationData['longitude'] ?? null,
                'place_id' => $locationData['place_id'] ?? null,
            ]);
        }
    }
}
