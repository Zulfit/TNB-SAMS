<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    protected static ?string $password;
    
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'tnbsamsa@tnb.com.my',
                'email_verified_at' => now(),
                'id_staff' => 'TNB001',
                'position' => 'Admin',
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Fathul',
                'email' => 'fathul@tnb.com.my',
                'email_verified_at' => now(),
                'id_staff' => 'TNB002',
                'position' => 'Manager',
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Akmal',
                'email' => 'akmal@tnb.com.my',
                'email_verified_at' => now(),
                'id_staff' => 'TNB003',
                'position' => 'Staff',
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Safwan',
                'email' => 'safwan@tnb.com.my',
                'email_verified_at' => null,
                'id_staff' => 'TNB004',
                'position' => 'Staff',
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Aqhila',
                'email' => 'aqhila@tnb.com.my',
                'email_verified_at' => null,
                'id_staff' => 'TNB005',
                'position' => 'Manager',
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($users as $user){
            User::create($user);
        }
    }
}
