<?php

namespace App\Console;

use App\Console\Commands\CronReport;
use App\Console\Commands\CronTask;
use App\Console\Commands\CronTest;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CronTest::class,
        CronTask::class,
        CronReport::class,
    ];
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {



        $schedule->command('cron:answer')->daily();
        // $schedule->command('cron:test')->everyMinute();
        $schedule->command('cron:task')->everyMinute();
        $schedule->command('cron:report')->everyMinute();
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
