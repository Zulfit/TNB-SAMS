<?php

namespace Database\Seeders;

use App\Models\Panels;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panels = [
            [
                'panel_name' => 'Bus Section 30'
            ],
            [
                'panel_name' => 'Bus Coupler 34'
            ],
            [
                'panel_name' => 'Feeder 1'
            ],
            [
                'panel_name' => 'Feeder 2'
            ],
            [
                'panel_name' => 'Feeder 3'
            ],
        ];

        foreach ($panels as $panel){
            Panels::create($panel);
        }
    }
}
