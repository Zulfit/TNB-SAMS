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
            //KLCC-BS30
            [
                'sensor_name' => 'KLCC_TH_BS30_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_MBSB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 1,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_BS30_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_CBT_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_CBT_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_BS30_CBB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_CBB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_CBB_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_BS30_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_CBL_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_CBL_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS30_CBL_004',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 1,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_PD_BS30_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_BS30_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_BS30_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 1,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],

            //KLCC-BC34
            [
                'sensor_name' => 'KLCC_TH_BS34_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_MBSB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 1,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_BS34_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_CBT_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_CBT_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_BS34_CBB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_CBB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_CBB_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_BS34_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_CBL_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_CBL_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_BS34_CBL_004',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 2,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_PD_BS34_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_BS34_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_BS34_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 2,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            
            //KLCC-FD1
            [
                'sensor_name' => 'KLCC_TH_FD1_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_MBSB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 1,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD1_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_CBT_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_CBT_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD1_CBB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_CBB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_CBB_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD1_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_CBL_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_CBL_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD1_CBL_004',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 3,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_PD_FD1_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_FD1_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_FD1_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 3,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],

            //KLCC-FD2
            [
                'sensor_name' => 'KLCC_TH_FD2_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_MBSB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 1,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD2_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_CBT_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_CBT_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD2_CBB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_CBB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_CBB_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD2_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_CBL_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_CBL_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD2_CBL_004',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 4,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_PD_FD2_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_FD2_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_FD2_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 4,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],

            //KLCC-FD3
            [
                'sensor_name' => 'KLCC_TH_FD3_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 5,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_MBSB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 1,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD3_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 5,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_CBT_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_CBT_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 3,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD3_CBB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 5,
                'sensor_compartment' => 4,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_CBB_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_CBB_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 4,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_TH_FD3_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 5,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Temperature',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_CBL_002',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_CBL_003',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            // [
            //     'sensor_name' => 'KLCC_TH_FD3_CBL_004',
            //     'sensor_substation' => 1,
            //     'sensor_panel' => 5,
            //     'sensor_compartment' => 5,
            //     'sensor_measurement' => 'Temperature',
            //     'sensor_date' => '2024-12-01',
            //     'sensor_status' => 'Online'
            // ],
            [
                'sensor_name' => 'KLCC_PD_FD3_MBSB_001',
                'sensor_substation' => 1,
                'sensor_panel' => 5,
                'sensor_compartment' => 1,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_FD3_CBT_001',
                'sensor_substation' => 1,
                'sensor_panel' => 5,
                'sensor_compartment' => 3,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],
            [
                'sensor_name' => 'KLCC_PD_FD3_CBL_001',
                'sensor_substation' => 1,
                'sensor_panel' => 5,
                'sensor_compartment' => 5,
                'sensor_measurement' => 'Partial Discharge',
                'sensor_date' => '2024-12-01',
                'sensor_status' => 'Online'
            ],

        ];

        foreach ($sensors as $sensor) {
            Sensor::create($sensor);
        }
    }
}
