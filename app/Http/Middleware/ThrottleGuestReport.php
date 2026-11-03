<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleGuestReport
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            return $next($request);
        }

        $key = 'guest-report:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            abort(429, 'Terlalu banyak laporan dari perangkat ini. Coba lagi nanti.');
        }

        RateLimiter::hit($key, 3600);

        return $next($request);
    }
}
