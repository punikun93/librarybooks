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
        return [
            'UserID' => $this->faker->unique()->numberBetween(1, 1000),
            'Username' => $this->faker->userName,
            'password' => Hash::make('password'), // default password for testing
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'NamaLengkap' => $this->faker->name,
            'Alamat' => $this->faker->address,
            'Role' => $this->faker->randomElement(['user', 'petugas', 'admin']),
            'Status' => $this->faker->randomElement(['Pending', 'Confirmed']),
        'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
