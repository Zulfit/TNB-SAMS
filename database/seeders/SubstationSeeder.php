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
        ];

        foreach ($substations as $substation) {
            Substation::create($substation);
        }
    }
}
