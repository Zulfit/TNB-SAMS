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
                'substation_date' => '2024-12-01',
            ],
            [
                'substation_name' => 'PPU BTRZ',
                'substation_location' => 'BTRZ/KVT/G0002',
                'substation_date' => '2024-12-01',
            ],
            [
                'substation_name' => 'PPU TASIK TAMBAHAN',
                'substation_location' => 'TBHN/KVT/G0003',
                'substation_date' => '2024-12-01',
            ],
            [
                'substation_name' => 'PPU KOMPLEKS SUKAN',
                'substation_location' => 'KPSN/KVT/G0004',
                'substation_date' => '2025-02-01',
            ],
            [
                'substation_name' => 'SSU MATRADE',
                'substation_location' => 'MTRD/KVT/G0005',
                'substation_date' => '2025-02-01',
            ],
            [
                'substation_name' => 'PPU WANGSA MAJU',
                'substation_location' => 'WSMJ/KVT/G0006',
                'substation_date' => '2025-02-01',
            ],
            [
                'substation_name' => 'PPU ALAM DAMAI',
                'substation_location' => 'AMDI/KVT/G0007',
                'substation_date' => '2025-02-01',
            ],
            [
                'substation_name' => 'PPU HUKM',
                'substation_location' => 'HUKM/KVT/G0008',
                'substation_date' => '2025-02-01',
            ],
            [
                'substation_name' => 'PPU YOW CHUAN',
                'substation_location' => 'YWCN/KVT/G0009',
                'substation_date' => '2025-02-01',
            ],
            [
                'substation_name' => 'PPU METROPLEX',
                'substation_location' => 'MTPX/KVT/G0010',
                'substation_date' => '2025-02-01',
            ],
        ];

        foreach ($substations as $substation) {
            Substation::create($substation);
        }
    }
}
