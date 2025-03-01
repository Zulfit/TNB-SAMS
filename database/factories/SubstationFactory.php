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
        return [
            'substation_name' => $this->faker->randomElement([
                'Substation Ampang',
                'Substation Cheras',
                'Substation Putrajaya',
                'Substation Klang',
                'Substation Bangi'
            ]),
            'substation_location' => $this->faker->randomElement([
                'No 123, Jalan Ampang, 68000, Selangor, Malaysia',
                'No 456, Jalan Cheras, 56100, Kuala Lumpur, Malaysia',
                'No 789, Persiaran Putrajaya, 62000, Putrajaya, Malaysia',
                'No 321, Jalan Meru, 41050, Klang, Selangor, Malaysia',
                'No 654, Jalan Bangi, 43650, Bangi, Selangor, Malaysia'
            ]),
            'substation_date' => $this->faker->dateTimeBetween('2024-01-01', '2025-12-31')->format('Y-m-d'),
        ];

    }
}
