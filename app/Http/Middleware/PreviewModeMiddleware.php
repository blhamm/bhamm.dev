<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreviewModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $previewToken = config('services.pennant.preview_token');

        if ($previewToken && $request->query('preview_mode') === $previewToken) {
            session(['preview_mode' => true]);
        }

        return $next($request);
    }
}
