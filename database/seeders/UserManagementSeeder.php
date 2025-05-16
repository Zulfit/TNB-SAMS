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
                'user_id' => 1,
                'permissions' => [
                    'dashboard_access' => ['full'],
                    'analytics_access' => ['full'],
                    'error_log_access' => ['full'],
                    'dataset_access' => ['full'],
                    'substation_access' => ['full'],
                    'sensor_access' => ['full'],
                    'report_access' => ['full'],
                    'user_management_access' => ['full'],
                ],
            ],
            [
                'user_id' => 2,
                'permissions' => [
                    'dashboard_access' => ['full'],
                    'analytics_access' => ['full'],
                    'error_log_access' => ['view', 'create'],
                    'dataset_access' => ['view', 'create', 'edit'],
                    'substation_access' => ['view', 'create'],
                    'sensor_access' => ['view'],
                    'report_access' => ['view', 'create', 'edit'],
                    'user_management_access' => ['full'],
                ],
            ],
            [
                'user_id' => 3,
                'permissions' => [
                    'dashboard_access' => ['full'],
                    'analytics_access' => ['full'],
                    'error_log_access' => ['full'],
                    'dataset_access' => ['view'],
                    'substation_access' => ['create', 'edit', 'delete'],
                    'sensor_access' => ['view', 'create', 'delete'],
                    'report_access' => ['full'],
                    'user_management_access' => ['view', 'edit'],
                ],
            ],
        ];

        foreach ($user_managements as $user_management) {
            UserManagement::create([
                'user_id' => $user_management['user_id'],
                'permissions' => $user_management['permissions'], // no json_encode here
            ]);
        }
    }
}
