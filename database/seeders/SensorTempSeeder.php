<?php

namespace Database\Seeders;

use App\Models\ErrorLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorTempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startTime = Carbon::create(now()->year, 4, 1)->startOfDay();
        // $endTime = Carbon::create(now()->year, 5, 31)->endOfDay();
        $endTime = now();
        $data = [];

        $sensorIds = DB::table('sensors')
            ->where('sensor_measurement', 'Temperature')
            ->where('sensor_status', 'Online')
            ->pluck('id')
            ->toArray();


        while ($startTime <= $endTime) {
            foreach ($sensorIds as $sensorId) {
                // Biased temperature generation for more 'normal' data
                $levelRoll = rand(1, 100);

                if ($levelRoll <= 80) {
                    // Normal (80%)
                    $base = rand(25, 30);
                    $red = $base + rand(-5, 5) / 10;
                    $yellow = $base + rand(-5, 5) / 10;
                    $blue = $base + rand(-5, 5) / 10;
                } elseif ($levelRoll <= 95) {
                    // Warn (15%)
                    $base = rand(25, 30);
                    $red = $base + rand(-10, 10) / 10;
                    $yellow = $base + rand(-15, 15) / 10;
                    $blue = $base + rand(-10, 10) / 10;
                } else {
                    // Critical (5%)
                    $base = rand(25, 30);
                    $red = $base + rand(-20, 20) / 10;
                    $yellow = $base + rand(-25, 25) / 10;
                    $blue = $base + rand(-20, 20) / 10;
                }

                $temps = [$red, $yellow, $blue];
                $max = max($temps);
                $min = min($temps);
                $diff = $max - $min;
                $variance = round(($max - $min) / $max * 100, 2);

                if ($diff >= 1) {
                    $alertLevel = 'critical';
                } elseif ($diff >= 0.8) {
                    $alertLevel = 'warn';
                } else {
                    $alertLevel = 'normal';
                }

                $data[] = [
                    'sensor_id' => $sensorId,
                    'red_phase_temp' => $red,
                    'yellow_phase_temp' => $yellow,
                    'blue_phase_temp' => $blue,
                    'max_temp' => $max,
                    'min_temp' => $min,
                    'diff_temp' => $diff,
                    'variance_percent' => $variance,
                    'alert_triggered' => $alertLevel,
                    'created_at' => $startTime->copy(),
                    'updated_at' => $startTime->copy(),
                ];
            }

            // Insert in chunks of 1000
            if (count($data) >= 1000) {
                DB::table('sensor_temperature')->insert($data);
                unset($data);
                $data = [];
            }

            $startTime->addMinutes(5);
        }

        // Insert any remaining records
        if (!empty($data)) {
            DB::table('sensor_temperature')->insert($data);
        }
    }
}
