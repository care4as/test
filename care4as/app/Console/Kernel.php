<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ImportIntermediateReport;
use App\Jobs\Intermediate;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
      'App\Console\Commands\ImportIntermediateReport',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();
        // $schedule->command('jobexp:warning')->cron('* * * * *');
        // $schedule->job(new Intermediate)->daily()->everyThirtyMinutes()->between('8:30', '22:00');
        // $schedule->command('import:Intermediate')->daily()->everyThirtyMinutes()->between('8:30', '22:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
