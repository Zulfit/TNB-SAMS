<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InsertDummyCriticalData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:dummy-critical';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert dummy critical sensor data';

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

            $red = 40.0;
            $yellow = 37.5;
            $blue = 35.2;
            $temps = [$red, $yellow, $blue];
            $max = max($temps);
            $min = min($temps);
            $variance = round(($max - $min) / $max * 100,2);

            $alertLevel = match (true) {
                $variance >= 12 => 'critical',
                $variance >= 10 => 'warn',
                default => 'normal',
            };

            $data[] = [
                'sensor_id' => 1,
                'red_phase_temp' => $red,
                'yellow_phase_temp' => $yellow,
                'blue_phase_temp' => $blue,
                'max_temp' => $max,
                'min_temp' => $min,
                'variance_percent' => $variance,
                'alert_triggered' => $alertLevel,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        

        DB::table('sensor_temperature')->insert($data);

        $this->info('Inserted dummy data for ' . count($data) . ' sensors at ' . $now);
    }
}
