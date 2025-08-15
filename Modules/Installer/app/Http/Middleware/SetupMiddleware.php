<?php

namespace Modules\Installer\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SetupMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty(config('app.key'))) {
            Artisan::call('key:generate');
            Artisan::call('config:cache');
        }
        $setupStatus = setupStatus();
        if ($request->is('setup/*')) {
            if ($setupStatus) {
                return redirect()->route('home');
            }

            return $next($request);
        }
        if (! $setupStatus) {
            return redirect()->route('setup.verify');
        }

        return $next($request);
    }
}
