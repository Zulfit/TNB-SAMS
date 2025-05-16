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
                'permissions' => [
                    'dashboard_access' => ['full', 'view'],
                    'analytics_access' => ['view', 'create'],
                    'dataset_access' => ['view', 'create', 'edit'],
                    'substation_access' => ['full', 'view', 'create'],
                    'asset_access' => ['edit', 'delete'],
                    'sensor_access' => ['full'],
                    'report_access' => ['view', 'create', 'edit'],
                    'user_management_access' => ['full', 'view', 'create', 'edit', 'delete'],
                ],
            ],
            [
                'user_id' => 3,
                'permissions' => [
                    'dashboard_access' => ['view', 'create', 'edit'],
                    'analytics_access' => ['full'],
                    'dataset_access' => ['view'],
                    'substation_access' => ['create', 'edit', 'delete'],
                    'asset_access' => ['full', 'view'],
                    'sensor_access' => ['view', 'create', 'delete'],
                    'report_access' => ['full', 'delete'],
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
