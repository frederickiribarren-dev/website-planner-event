<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Invitado;
use App\Models\ListaInvitado;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvitadoFactory extends Factory
{
    protected $model = Invitado::class;

    public function definition(): array
    {
        return [
            'evento_id'          => Evento::factory(),
            'lista_invitado_id'  => null,
            'nombre'             => fake()->name(),
            'email'              => fake()->unique()->safeEmail(),
            'telefono'           => fake()->numerify('###-###-####'),
            'token_acceso'       => null,
            'estado_invitacion'  => 'Pendiente',
            'estado_asistencia'  => 'Sin responder',
            'cantidad_adultos'   => 1,
            'cantidad_ninos'     => 0,
            'alergias_notas'     => null,
            'fecha_confirmacion' => null,
        ];
    }
}
