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
                'sensor_name' => 'KLCC_TH_BS30_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_BS30_CBT_002',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_BS30_CBB_003',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_BS30_CBL_004',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_BC34_MBSB_005',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_BC34_CBT_006',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_BC34_CBB_007',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_BC34_CBL_008',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_FD1_MBSB_009',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_FD1_CBT_010',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_TH_FD1_CBB_011',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_FD1_CBL_012',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
        ];

        foreach ($sensors as $sensor){
            Sensor::create($sensor);
        }
    }
}
