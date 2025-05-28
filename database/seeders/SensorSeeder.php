<?php

namespace Database\Seeders;

use App\Models\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sensors = [
            [
                'sensor_name' => '10004001_TH_BBM_Y_IS',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '10004002_TH_BBM_Y_IS',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 2,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '10004002_TH_BBM_Y_IS',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '10004002_TH_BBM_Y_IS',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '20004001_TH_BBM_IS',
                'sensor_substation' => 2,
                'sensor_panel' => 1,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '20004001_TH_BBM_IS',
                'sensor_substation' => 2,
                'sensor_panel' => 2,
                'sensor_compartment' => 2,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '20004001_TH_BBM_IS',
                'sensor_substation' => 2,
                'sensor_panel' => 3,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => now(),
                'sensor_status' => 'Inactive'
            ],
            [
                'sensor_name' => '30004001_TH_BBM_B_IS',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '30004001_TH_BBM_B_IS',
                'sensor_substation' => 2,
                'sensor_panel' => 2,
                'sensor_compartment' => 2,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => now(),
                'sensor_status' => 'Active'
            ],
            [
                'sensor_name' => '30004001_TH_BBM_B_IS',
                'sensor_substation' => 3,
                'sensor_panel' => 3,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => now(),
                'sensor_status' => 'Inactive'
            ],
        ];

        foreach ($sensors as $sensor){
            Sensor::create($sensor);
        }
    }
}
