<?php

namespace Database\Seeders;

use App\Models\ErrorLog;
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
                'sensor_id' => 1,
                'state' => 'ALARM',
                'threshold' => '>= 50 for 300s',
                'severity' => 'CRITICAL',
            ],
            [
                'sensor_id' => 2,
                'state' => 'NORMAL',
                'threshold' => '>= 80 for 200s',
                'severity' => 'SAFE',
            ],
            [
                'sensor_id' => 3,
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
