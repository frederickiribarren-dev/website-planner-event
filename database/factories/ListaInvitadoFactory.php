<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\ListaInvitado;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListaInvitadoFactory extends Factory
{
    protected $model = ListaInvitado::class;

    public function definition(): array
    {
        return [
            'evento_id' => Evento::factory(),
            'nombre' => fake()->words(2, true),
            'categoria' => 'General',
        ];
    }
}
