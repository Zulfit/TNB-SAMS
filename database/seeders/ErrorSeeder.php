<?php

namespace Database\Seeders;

use App\Models\ErrorLog;
use App\Models\SensorTemperature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ErrorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $errors = [
            [
                'sensor_id' => 158113,
                'sensor_type' => SensorTemperature::class,
                'state' => 'AWAIT',
                'threshold' => '>= 50 for 3600s',
                'severity' => 'WARN',
            ],
            [
                'sensor_id' => 158114,
                'sensor_type' => SensorTemperature::class,
                'state' => 'ALARM',
                'threshold' => '>= 50 for 300s',
                'severity' => 'CRITICAL',
            ],
            [
                'sensor_id' => 158115,
                'sensor_type' => SensorTemperature::class,
                'state' => 'AWAIT',
                'threshold' => '>= 50 for 3600s',
                'severity' => 'WARN',
            ],
            [
                'sensor_id' => 158116,
                'sensor_type' => SensorTemperature::class,
                'state' => 'AWAIT',
                'threshold' => '>= 50 for 3600s',
                'severity' => 'WARN',
            ],
        ];

        foreach($errors as $error)
        {
            ErrorLog::create($error);
        }
    }
}
