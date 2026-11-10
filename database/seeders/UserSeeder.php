<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Demo accounts only. The password comes from SEED_USER_PASSWORD
     * (config app.seed_user_password) and defaults to the local demo value.
     */
    public function run(): void
    {
        $password = Hash::make((string) config('app.seed_user_password', 'password'));

        $users = [
            [
                'name' => 'Example Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'id_staff' => 'EX001',
                'position' => 'Admin',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Example Manager',
                'email' => 'manager@example.com',
                'email_verified_at' => now(),
                'id_staff' => 'EX002',
                'position' => 'Manager',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Example Staff',
                'email' => 'staff@example.com',
                'email_verified_at' => now(),
                'id_staff' => 'EX003',
                'position' => 'Staff',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Example Staff Pending',
                'email' => 'staff.pending@example.com',
                'email_verified_at' => null,
                'id_staff' => 'EX004',
                'position' => 'Staff',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Example Manager Pending',
                'email' => 'manager.pending@example.com',
                'email_verified_at' => null,
                'id_staff' => 'EX005',
                'position' => 'Manager',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
