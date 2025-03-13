<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Substation>
 */
class SubstationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $substations = [
            [
                'substation_name' => 'PMU KLCC',
                'substation_location' => 'KLCC/KVT/G0001',
            ],
            [
                'substation_name' => 'PPU BTRZ',
                'substation_location' => 'BTRZ/KVT/G0002',
            ],
            [
                'substation_name' => 'PPU TASIK TAMBAHAN',
                'substation_location' => 'TBHN/KVT/G0003',
            ]
        ];
    
        // Pick one randomly for variation
        $substation = $this->faker->randomElement($substations);
    
        return [
            'substation_name' => $substation['substation_name'],
            'substation_location' => $substation['substation_location'],
            'substation_date' => $this->faker->dateTimeBetween('2024-01-01', '2025-12-31')->format('Y-m-d'),
        ];
    }
}
