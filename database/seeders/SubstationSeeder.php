<?php

namespace Database\Seeders;

use App\Models\Substation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubstationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we don't duplicate records
        // Substation::truncate();

        // Seed exactly one of each substation
        $substations = [
            [
                'substation_name' => 'PMU KLCC',
                'substation_location' => 'KLCC/KVT/G0001',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU BTRZ',
                'substation_location' => 'BTRZ/KVT/G0002',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU TASIK TAMBAHAN',
                'substation_location' => 'TBHN/KVT/G0003',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU TASIK TOLAKAN',
                'substation_location' => 'TBHN/KVT/G0004',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU TASIK CERMIN',
                'substation_location' => 'TBHN/KVT/G0005',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU UK',
                'substation_location' => 'TBHN/KVT/G0006',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU BARU BANGI',
                'substation_location' => 'TBHN/KVT/G0007',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU PANDAN INDAH',
                'substation_location' => 'TBHN/KVT/G0008',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU SETAPAK',
                'substation_location' => 'TBHN/KVT/G0009',
                'substation_date' => now(),
            ],
            [
                'substation_name' => 'PPU KAJANG',
                'substation_location' => 'TBHN/KVT/G0010',
                'substation_date' => now(),
            ],
        ];

        foreach ($substations as $substation) {
            Substation::create($substation);
        }
    }
}
