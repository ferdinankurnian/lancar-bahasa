<?php

namespace Modules\Installer\app\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Installer\app\Enums\InstallerInfo;
use Modules\Installer\app\Models\Configuration;

class PurchaseVerifyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (strtolower(config('app.app_mode')) == 'demo') {
            return $next($request);
        }

        if (InstallerInfo::licenseFileExist()) {
            $filepath = InstallerInfo::getLicenseFilePath();
            if (! InstallerInfo::isRemoteLocal() && InstallerInfo::licenseFileDataHasLocalTrue()) {
                $response = purchaseVerificationHashed($filepath, true);
                if ($response && InstallerInfo::rewriteHashedFile($response)) {
                    return $next($request);
                } else {
                    InstallerInfo::deleteLicenseFile();

                    return $this->invalidHashed();
                }
            } elseif (Carbon::now()->day == 1) {
                $response = purchaseVerificationHashed($filepath);
                if ($response && $response['success']) {
                    return $next($request);
                }

                return $this->invalidHashed();
            }

            return $next($request);
        }

        return $this->invalidHashed();
    }

    private function invalidHashed()
    {
        try {
            Configuration::updateCompeteStatus(0);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        Session::flush();
        Artisan::call('cache:clear');

        return redirect()->route('setup.verify');
    }
}
