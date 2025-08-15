<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cachedSetting = Cache::get('setting', null);
        if ($cachedSetting !== null && $cachedSetting?->maintenance_mode) {
            return redirect()->route('maintenance.mode')->with([
                'alert-type' => 'error',
                'messege' => __("Under Maintenance Mode you can't access"),
            ]);
        }

        return $next($request);
    }
}
