<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $isFirst = true;
        if ($isFirst == true) {

            $isFirst = false;

            return [

                'name' => 'Admin',
                'email' => 'tnbsamsa@gmail.com',
                'email_verified_at' => now(),
                'id_staff' => 'TNB001',
                'position' => 'Admin',
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
            ];         
        }

        else{

            return [

                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'email_verified_at' => null,
                'id_staff' => 'TNB00'.$this->faker->unique()->numberBetween(2,10),
                'position' => $this->faker->randomElement([
                    'Staff',
                    'Manager'
                ]),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
            ];
        }
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
