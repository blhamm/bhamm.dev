<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleAiBots
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = strtolower($request->header('User-Agent', ''));
        $accept = $request->header('Accept', '');

        if ($this->isAIUserAgentRequest($accept, $userAgent)) {
            $path = public_path('llms-full.txt');

            if (file_exists($path)) {
                return response(file_get_contents($path), 200, [
                    'Content-Type' => 'text/markdown; charset=UTF-8',
                ]);
            }
        }

        return $next($request);
    }

    public function isAIUserAgentRequest(array|string|null $accept, string $userAgent): bool
    {
        return str_contains($accept, 'text/markdown') || str_contains($userAgent, 'gptbot') || str_contains($userAgent, 'claudebot') || str_contains($userAgent, 'perplexitybot');
    }
}
