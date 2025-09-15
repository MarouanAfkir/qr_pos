<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // WEB session: user must be admin
        if (Auth::guard('web')->check() && (Auth::user()->is_admin ?? false)) {
            return $next($request);
        }

        // Sanctum token: must have 'admin' ability
        $user = $request->user('sanctum');
        if ($user && $request->user()?->currentAccessToken()?->can('admin')) {
            return $next($request);
        }

        abort(403);
    }
}
