<?php

use App\Models\Evento;
use App\Models\Invitado;
use App\Models\ListaInvitado;
use App\Models\User;

test('user can create a guest list and add a guest to it', function () {
    $user = User::factory()->create();
    $evento = Evento::factory()->create(['usuario_id' => $user->id]);

    $this->actingAs($user)
        ->post(route('eventos.listas-invitados.store', $evento), [
            'nombre' => 'Familia',
            'categoria' => 'General',
        ])
        ->assertRedirect(route('eventos.listas-invitados.index', $evento))
        ->assertSessionHas('success');

    $lista = ListaInvitado::where('evento_id', $evento->id)->first();

    expect($lista)->not->toBeNull()
        ->and($lista->nombre)->toBe('Familia');

    $this->actingAs($user)
        ->post(route('listas-invitados.addGuest', $lista), [
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'telefono' => '5551234567',
        ])
        ->assertRedirect(route('listas-invitados.edit', $lista))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('invitados', [
        'lista_invitado_id' => $lista->id,
        'evento_id' => $evento->id,
        'nombre' => 'Juan Pérez',
        'email' => 'juan@example.com',
        'estado_invitacion' => 'Pendiente',
        'estado_asistencia' => 'Sin responder',
    ]);

    expect(Invitado::where('lista_invitado_id', $lista->id)->count())->toBe(1);
});
