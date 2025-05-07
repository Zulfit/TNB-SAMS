<?php
namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\InsertDummyDataSensorTemp::class,
        \App\Console\Commands\InsertDummyDataSensorPD::class,
        \App\Console\Commands\InsertDummyWarnData::class,
        \App\Console\Commands\InsertDummyCriticalData::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('insert:dummy-sensor-pd')->everyFiveMinutes();
        $schedule->command('insert:dummy-sensor-temp')->everyFiveMinutes();
        // $schedule->command('insert:dummy-warn')->now();
        // $schedule->command('insert:dummy-critical')->now();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
