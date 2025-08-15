<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\PreNotification',
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // php artisan schedule:run >> /dev/null 2>&1
        // run queue jobs
        $schedule->command('queue:work --tries=3 --stop-when-empty')
            ->everyMinute()
            ->withoutOverlapping();


        $schedule->call(function () {
            Cache::forget('corn_working');
            Cache::remember('corn_working', now()->addHours(24), function () {
                return 'working';
            });
        })->everyFiveMinutes()->name('cron_test')->withoutOverlapping();

        //live mail notification send command
        $live_mail_send_minutes = cache()->get('setting')?->live_mail_send ?? 5;
        $cronExpression = "*/$live_mail_send_minutes * * * *";

        $schedule->command('prenotification:live')->cron($cronExpression)->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
