<?php

namespace Database\Seeders;

use App\Models\ErrorLog;
use App\Models\Substation;
use App\Models\User;
use App\Models\UserManagement;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $this->call(UserManagementSeeder::class);

        $this->call(SubstationSeeder::class);

        $this->call(PanelSeeder::class);

        $this->call(CompartmentSeeder::class);

        $this->call(SensorSeeder::class);

        $this->call(ErrorSeeder::class);

        $this->call(SensorTempSeeder::class);

        $this->call(SensorPDSedder::class);

    }
}
