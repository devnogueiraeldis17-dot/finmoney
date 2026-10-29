<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'birth_date' => fake()->date(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('Senha123!'),
            'role' => 'comum',
            'remember_token' => Str::random(10),
        ];
    }
}
