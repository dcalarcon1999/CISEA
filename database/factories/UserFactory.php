<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
            'name' => fake()->name(),
            'rut'  => fake()->numerify('#########') . '-' . fake()->randomElement(['0','1','2','3','4','5','6','7','8','9','K']),
            'email' => fake()->unique()->safeEmail(),
            'rol'  => 'operador',
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function operador(): static  { return $this->state(['rol' => 'operador']); }
    public function sip(): static       { return $this->state(['rol' => 'sip']); }
    public function jefatura(): static  { return $this->state(['rol' => 'jefatura']); }
    public function auditor(): static   { return $this->state(['rol' => 'auditor']); }
}
