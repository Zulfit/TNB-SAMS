<?php

namespace Database\Seeders;

use App\Models\Compartments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compartments = [
            [
                'compartment_name' => 'Main Busbar'
            ],
            [
                'compartment_name' => 'Reserve Busbar'
            ],
            [
                'compartment_name' => 'CB-Top'
            ],
            [
                'compartment_name' => 'CB-Bottom'
            ],
            [
                'compartment_name' => 'Cable Compartments'
            ],
        ];

        foreach ($compartments as $compartment){
            Compartments::create($compartment);
        }       
    }
}
