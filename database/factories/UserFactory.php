<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a la factoría.
     */
    protected $model = User::class;

    /**
     * Define el estado por defecto del modelo.
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password_hash' => bcrypt('password'), // Ajustado a tu columna password_hash
            'remember_token' => Str::random(10),
        ];
    }
}