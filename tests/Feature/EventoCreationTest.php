<?php

use App\Models\Evento;
use App\Models\User;

test('authenticated user can create an event', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('eventos.store'), [
        'slug' => 'baby-shower-sofia',
        'nombre_bebe' => 'Sofía',
        'genero_bebe' => 'Niña',
        'fecha_evento' => '2026-12-01',
        'ubicacion_nombre' => 'Casa de los abuelos',
    ]);

    $response
        ->assertRedirect(route('eventos.index'))
        ->assertSessionHas('status', 'Evento creado exitosamente');

    $this->assertDatabaseHas('eventos', [
        'usuario_id' => $user->id,
        'slug' => 'baby-shower-sofia',
        'nombre_bebe' => 'Sofía',
        'genero_bebe' => 'Niña',
        'ubicacion_nombre' => 'Casa de los abuelos',
    ]);

    expect(Evento::where('usuario_id', $user->id)->count())->toBe(1);
});
