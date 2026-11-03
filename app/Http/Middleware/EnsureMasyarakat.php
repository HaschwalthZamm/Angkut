<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMasyarakat
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasRole(UserRole::Masyarakat)) {
            abort(403);
        }

        return $next($request);
    }
}
