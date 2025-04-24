<?php
namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\InsertDummyDataSensorTemp::class,
        \App\Console\Commands\InsertDummyDataSensorPD::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('insert:dummy-sensor-pd')->everyFiveMinutes();
        $schedule->command('insert:dummy-sensor-temp')->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
