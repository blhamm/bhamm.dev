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
                $content = file_get_contents($path);
                if ($content !== false) {
                    return response($content, 200, [
                        'Content-Type' => 'text/markdown; charset=UTF-8',
                    ]);
                }
            }
        }

        return $next($request);
    }

    /**
     * @param  array<string>|string|null  $accept
     */
    public function isAIUserAgentRequest(array|string|null $accept, string $userAgent): bool
    {
        $acceptString = is_array($accept) ? implode(', ', $accept) : ($accept ?? '');

        return str_contains($acceptString, 'text/markdown') || str_contains($userAgent, 'gptbot') || str_contains($userAgent, 'claudebot') || str_contains($userAgent, 'perplexitybot');
    }
}
