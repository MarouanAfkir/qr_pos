<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, \Closure $next)
    {
        $u = $request->user('sanctum');
        if ($u && $request->user()?->currentAccessToken()?->can('pos')) {
            return $next($request);
        }
        abort(401); // or 403
    }
}
