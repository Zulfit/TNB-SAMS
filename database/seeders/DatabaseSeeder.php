<?php

namespace Database\Seeders;

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
        User::factory(5)->create();

        Substation::factory(5)->create();

        UserManagement::factory(2)->create();

    }
}
