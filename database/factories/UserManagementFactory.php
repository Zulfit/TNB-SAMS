<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserManagement>
 */
class UserManagementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(2,5),
            'dashboard_access' => $this->faker->numberBetween(1,5),
            'analytics_access' => $this->faker->numberBetween(1,5),
            'dataset_access' => $this->faker->numberBetween(1,5),
            'substation_access' => $this->faker->numberBetween(1,5),
            'asset_access' => $this->faker->numberBetween(1,5),
            'sensor_access' => $this->faker->numberBetween(1,5),
            'report_access' => $this->faker->numberBetween(1,5),
            'user_management_access' => $this->faker->numberBetween(1,5),
        ];
    }
}
