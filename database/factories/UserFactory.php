<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'password' => bcrypt('password'), 
            'email' => $this->faker->unique()->safeEmail(),
            'nama_lengkap' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'role' => 'peminjam',
            'remember_token' => Str::random(10)
        ];
    }
}
