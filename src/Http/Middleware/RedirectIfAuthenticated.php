<?php

namespace Shopfolio\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard(config('shopfolio.auth.guard'))->check()) {
            return redirect()->route('shopfolio.dashboard');
        }

        return $next($request);
    }
}
