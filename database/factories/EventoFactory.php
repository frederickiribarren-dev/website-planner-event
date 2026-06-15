<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventoFactory extends Factory
{
    protected $model = Evento::class;

    public function definition(): array
    {
        $nombre = fake()->firstName();

        return [
            'usuario_id' => User::factory(),
            'slug' => Str::slug($nombre.'-'.fake()->unique()->numerify('####')),
            'nombre_bebe' => $nombre,
            'genero_bebe' => fake()->randomElement(['Niño', 'Niña', 'Sorpresa', 'Múltiple']),
            'fecha_evento' => fake()->dateTimeBetween('+1 week', '+1 year'),
            'ubicacion_nombre' => fake()->city(),
            'estado' => 'Borrador',
        ];
    }
}
