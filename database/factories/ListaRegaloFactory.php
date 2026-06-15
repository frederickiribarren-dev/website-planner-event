<?php

namespace Database\Factories;

use App\Models\ListaRegalo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListaRegaloFactory extends Factory
{
    protected $model = ListaRegalo::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'evento_id'   => null,
            'nombre'      => fake()->words(3, true),
            'descripcion' => fake()->sentence(),
            'estado'      => 'Borrador',
        ];
    }
}
