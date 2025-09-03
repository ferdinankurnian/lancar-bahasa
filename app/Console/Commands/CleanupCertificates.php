<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanupCertificates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certificates:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes cached certificate files older than 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = storage_path('app/certificates');

        if (!File::isDirectory($directory)) {
            $this->info('Certificate cache directory does not exist. Nothing to clean up.');
            return;
        }

        $files = File::files($directory);
        $cutoffDate = now()->subDays(30);
        $deletedCount = 0;

        foreach ($files as $file) {
            if (File::lastModified($file) < $cutoffDate->getTimestamp()) {
                File::delete($file);
                $deletedCount++;
            }
        }

        $this->info($deletedCount . ' old certificate(s) deleted successfully.');
    }
}
