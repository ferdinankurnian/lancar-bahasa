<?php

namespace App\Providers;

use App\Enums\ThemeList;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Modules\GlobalSetting\app\Models\Setting;
use Modules\GlobalSetting\app\Models\SeoSetting;
use Modules\GlobalSetting\app\Models\CustomPagination;
use Modules\GlobalSetting\app\Models\MarketingSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
             /** Cache settings */
            $setting = Cache::rememberForever('setting', fn () => (object) Setting::pluck('value', 'key')->all());
            $marketing_setting = Cache::rememberForever('marketing_setting', fn () => (object) MarketingSetting::pluck('value', 'key')->all());
            $seo_setting = Cache::rememberForever('seo_setting', fn () => (object) SeoSetting::all()->groupBy('page_name')->mapWithKeys(function ($group, $pageName) {
                return [$pageName => $group->first()];
            }));

            if ($setting) {
                set_wasabi_config();
                set_aws_config();
            }
        } catch (\Throwable $th) {
            info($th);
            $setting = (object) ['timezone' => config('app.timezone'), 'site_theme' => ThemeList::MAIN->value];
            $marketing_setting = (object) [];
            $seo_setting = (object) [];
        }

        // Force HTTPS for all generated URLs when APP_URL is HTTPS
        if (str_contains(env('APP_URL'), 'https://')) {
            \URL::forceScheme('https');
        }

        /** Share settings to all views */
        View::composer('*', function ($view) use ($setting, $marketing_setting, $seo_setting) {
            $view->with(['setting' => $setting, 'marketing_setting' => $marketing_setting, 'seo_setting' => $seo_setting]);
        });

        // set timezone
        date_default_timezone_set($setting->timezone ?? config('app.timezone'));

        /** Register custom blade directives */
        $this->registerBladeDirectives();

        // Use Bootstrap 4 pagination
        Paginator::useBootstrapFour();

        // Define default homepage based on site_theme from setting, with fallback
        config(['app.default_homepage' => $setting?->site_theme ?? ThemeList::MAIN->value]);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('adminCan', function ($permission) {
            return "<?php if(auth()->guard('admin')->user()->can({$permission})): ?>";
        });

        Blade::directive('endadminCan', function () {
            return '<?php endif; ?>';
        });

        // Blade directive for checking the current theme
        Blade::directive('theme', function ($themes) {
            return "<?php if(in_array(config('app.default_homepage'), {$themes})): ?>";
        });

        Blade::directive('endtheme', function () {
            return '<?php endif; ?>';
        });
    }
}
