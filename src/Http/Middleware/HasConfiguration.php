<?php

namespace Shopfolio\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shopfolio\Models\System\Setting;

class HasConfiguration
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Setting::query()->where('key', 'shop_email')->exists()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['setup' => true]);
            }

            return redirect()->route('shopfolio.dashboard');
        }

        return $next($request);
    }
}
