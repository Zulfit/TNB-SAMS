<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertDummyDataSensorTemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:dummy-sensor-temp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert dummy sensor data every 5 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sensorIds = DB::table('sensors')
            ->where('sensor_measurement', 'Temperature')
            ->pluck('id')
            ->toArray();

        $now = now();
        $data = [];

        foreach ($sensorIds as $sensorId) {
            // Biased temperature generation for more 'normal' data
            $levelRoll = rand(1, 100);

            if ($levelRoll <= 80) {
                $base = rand(25, 30);
                $red = $base + rand(-5, 5) / 10;
                $yellow = $base + rand(-5, 5) / 10;
                $blue = $base + rand(-5, 5) / 10;
            } elseif ($levelRoll <= 95) {
                $base = rand(25, 30);
                $red = $base + rand(-10, 10) / 10;
                $yellow = $base + rand(-15, 15) / 10;
                $blue = $base + rand(-10, 10) / 10;
            } else {
                $base = rand(25, 30);
                $red = $base + rand(-20, 20) / 10;
                $yellow = $base + rand(-25, 25) / 10;
                $blue = $base + rand(-20, 20) / 10;
            }

            $temps = [$red, $yellow, $blue];
            $max = max($temps);
            $min = min($temps);
            $variance = ($max - $min) / $max * 100;

            $alertLevel = match (true) {
                $variance >= 15 => 'critical',
                $variance >= 10 => 'warn',
                default => 'normal',
            };

            $data[] = [
                'sensor_id' => $sensorId,
                'red_phase_temp' => $red,
                'yellow_phase_temp' => $yellow,
                'blue_phase_temp' => $blue,
                'max_temp' => $max,
                'min_temp' => $min,
                'variance_percent' => round($variance, 2),
                'alert_triggered' => $alertLevel,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('sensor_temperature')->insert($data);

        $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
    }
}
