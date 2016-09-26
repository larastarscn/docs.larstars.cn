<?php

namespace App\Console;

use App\Services\Documentation\Indexer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ClearPageCache::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // update en docs
        $schedule->exec('sh '. base_path('build/en.sh'))->dayliAt('07:00')->sendOutputTo(storage_path('logs/en.sh.log'));
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->command('docs:index', function () {
            app(Indexer::class)->indexAllDocuments();
        })->describe('Index all documentation on Algolia');
    }
}
