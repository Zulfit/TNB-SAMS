<?php

namespace Database\Seeders;

use App\Models\UserManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_managements = [
            [
                'user_id' => 2,
                'dashboard_access' => 1,
                'analytics_access' => 1,
                'dataset_access' => 2,
                'substation_access' => 2,
                'asset_access' => 3,
                'sensor_access' => 4,
                'report_access' => 4,
                'user_management_access' => 5,
            ],
            [
                'user_id' => 3,
                'dashboard_access' => 2,
                'analytics_access' => 1,
                'dataset_access' => 3,
                'substation_access' => 4,
                'asset_access' => 5,
                'sensor_access' => 2,
                'report_access' => 4,
                'user_management_access' => 1,
            ],
        ];

        foreach ($user_managements as $user_management){
            UserManagement::create($user_management);
        }
    }
}
