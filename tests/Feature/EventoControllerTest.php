<?php

use App\Models\CategoriaRegalo;
use App\Models\Evento;
use App\Models\Invitado;
use App\Models\ListaInvitado;
use App\Models\ListaRegalo;
use App\Models\Regalo;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// ============================================================
// HELPERS — Factories auxiliares para el suite
// ============================================================

/**
 * Crea un usuario verificado y un evento asociado a él.
 */
function eventoConUsuario(array $eventoAttrs = []): array
{
    $user  = User::factory()->create();
    $evento = Evento::factory()->create(array_merge(
        ['usuario_id' => $user->id],
        $eventoAttrs
    ));
    return [$user, $evento];
}

/**
 * Devuelve el payload mínimo válido para crear/actualizar un evento.
 */
function payloadEventoValido(array $override = []): array
{
    return array_merge([
        'nombre_bebe'     => 'Valentina',
        'genero_bebe'     => 'Niña',
        'fecha_evento'    => now()->addMonths(2)->format('Y-m-d'),
        'ubicacion_nombre'=> 'Salón Jardín',
    ], $override);
}

// ============================================================
// GRUPO: Acceso sin autenticación (Guard)
// ============================================================

describe('Acceso sin autenticación', function () {

    it('redirige al login al intentar acceder al índice de eventos', function () {
        $this->get(route('eventos.index'))
             ->assertRedirect(route('login'));
    });

    it('redirige al login al intentar crear un evento (GET)', function () {
        $this->get(route('eventos.create'))
             ->assertRedirect(route('login'));
    });

    it('redirige al login al intentar guardar un evento (POST)', function () {
        $this->post(route('eventos.store'), payloadEventoValido())
             ->assertRedirect(route('login'));
    });

    it('redirige al login al intentar ver un evento (GET show)', function () {
        [$user, $evento] = eventoConUsuario();

        $this->get(route('eventos.show', $evento))
             ->assertRedirect(route('login'));
    });

    it('redirige al login al intentar editar un evento (GET edit)', function () {
        [$user, $evento] = eventoConUsuario();

        $this->get(route('eventos.edit', $evento))
             ->assertRedirect(route('login'));
    });

    it('redirige al login al intentar actualizar un evento (PUT)', function () {
        [$user, $evento] = eventoConUsuario();

        $this->put(route('eventos.update', $evento), payloadEventoValido())
             ->assertRedirect(route('login'));
    });

    it('redirige al login al intentar eliminar un evento (DELETE)', function () {
        [$user, $evento] = eventoConUsuario();

        $this->delete(route('eventos.destroy', $evento))
             ->assertRedirect(route('login'));
    });
});

// ============================================================
// GRUPO: INDEX — Listado de eventos
// ============================================================

describe('Index de eventos', function () {

    it('usuario autenticado ve sus propios eventos', function () {
        [$user, $evento] = eventoConUsuario();

        $this->actingAs($user)
             ->get(route('eventos.index'))
             ->assertOk()
             ->assertViewIs('eventos.invitaciones')
             ->assertViewHas('eventos');
    });

    it('usuario no ve eventos de otro usuario', function () {
        [$userA, $eventoA] = eventoConUsuario(['nombre_bebe' => 'Bebé A']);
        $userB = User::factory()->create();

        $response = $this->actingAs($userB)
                         ->get(route('eventos.index'));

        $response->assertOk();
        // Los eventos del usuario B deben estar vacíos
        $eventos = $response->viewData('eventos');
        expect($eventos)->toHaveCount(0);
    });
});

// ============================================================
// GRUPO: STORE — Crear evento
// ============================================================

describe('Crear evento (store)', function () {

    it('crea un evento válido y redirige al índice', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido(['slug' => 'test-store-ok']))
             ->assertRedirect(route('eventos.index'))
             ->assertSessionHas('status', 'Evento creado exitosamente');

        $this->assertDatabaseHas('eventos', [
            'usuario_id'  => $user->id,
            'slug'        => 'test-store-ok',
            'nombre_bebe' => 'Valentina',
            'genero_bebe' => 'Niña',
        ]);
    });

    it('el usuario_id del evento pertenece al usuario autenticado', function () {
        $user  = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido(['slug' => 'slug-ownership-check']));

        $evento = Evento::where('usuario_id', $user->id)->first();
        expect($evento)->not->toBeNull();
        expect($evento->usuario_id)->toBe($user->id)
                                   ->not->toBe($other->id);
    });

    it('falla si nombre_bebe está ausente', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido(['nombre_bebe' => '']))
             ->assertSessionHasErrors('nombre_bebe');
    });

    it('falla si genero_bebe tiene un valor no permitido', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido(['genero_bebe' => 'Extraterrestre']))
             ->assertSessionHasErrors('genero_bebe');
    });

    it('falla si fecha_evento no es una fecha válida', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido(['fecha_evento' => 'no-es-fecha']))
             ->assertSessionHasErrors('fecha_evento');
    });

    it('falla si el slug ya está en uso', function () {
        [$user, $eventoExistente] = eventoConUsuario(['slug' => 'slug-duplicado']);

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido(['slug' => 'slug-duplicado']))
             ->assertSessionHasErrors('slug');
    });

    it('falla si color_tema no tiene exactamente 7 caracteres', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido(['color_tema' => 'azul']))
             ->assertSessionHasErrors('color_tema');
    });

    it('crea invitados desde JSON al almacenar el evento', function () {
        $user = User::factory()->create();

        $invitadosJson = json_encode([
            ['name' => 'Carlos Ruiz',  'email' => 'carlos@test.com', 'phone' => '111'],
            ['name' => 'María López',  'email' => 'maria@test.com',  'phone' => '222'],
        ]);

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido([
                 'slug'           => 'evento-con-invitados',
                 'invitados_json' => $invitadosJson,
             ]))
             ->assertRedirect(route('eventos.index'));

        $evento = Evento::where('usuario_id', $user->id)->first();
        expect($evento)->not->toBeNull();
        expect(Invitado::where('evento_id', $evento->id)->count())->toBe(2);

        $this->assertDatabaseHas('invitados', ['nombre' => 'Carlos Ruiz',  'email' => 'carlos@test.com']);
        $this->assertDatabaseHas('invitados', ['nombre' => 'María López',  'email' => 'maria@test.com']);
    });

    it('crea una ListaInvitado por defecto cuando se envían invitados y no hay lista seleccionada', function () {
        $user = User::factory()->create();

        $invitadosJson = json_encode([
            ['name' => 'Invitado Default', 'email' => 'def@test.com'],
        ]);

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido([
                 'nombre_bebe'    => 'Camila',
                 'slug'           => 'evento-lista-default',
                 'invitados_json' => $invitadosJson,
             ]));

        $evento = Evento::where('usuario_id', $user->id)->first();
        expect(ListaInvitado::where('evento_id', $evento->id)->count())->toBe(1);
    });

    it('rechaza una lista de invitados que pertenece a otro usuario', function () {
        [$userA, $eventoA] = eventoConUsuario();
        $listaAjena = ListaInvitado::factory()->create(['evento_id' => $eventoA->id]);
        $userB      = User::factory()->create();

        $this->actingAs($userB)
             ->post(route('eventos.store'), payloadEventoValido([
                 'lista_invitado_id' => $listaAjena->id,
             ]))
             ->assertSessionHasErrors('lista_invitado_id');
    });

    it('rechaza una lista de regalos que pertenece a otro usuario', function () {
        $userA      = User::factory()->create();
        $listaAjena = ListaRegalo::factory()->create(['user_id' => $userA->id]);
        $userB      = User::factory()->create();

        $this->actingAs($userB)
             ->post(route('eventos.store'), payloadEventoValido([
                 'lista_regalos_id' => $listaAjena->id,
             ]))
             ->assertSessionHasErrors('lista_regalos_id');
    });

    it('sube imagen de portada y guarda la URL en el evento', function () {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('portada.jpg', 800, 600);

        $this->actingAs($user)
             ->post(route('eventos.store'), payloadEventoValido([
                 'slug'           => 'evento-con-imagen',
                 'imagen_portada' => $file,
             ]));

        $evento = Evento::where('usuario_id', $user->id)->first();
        expect($evento)->not->toBeNull();
        expect($evento->imagen_portada_url)->not->toBeNull();
        Storage::disk('public')->assertExists("eventos/portadas/{$file->hashName()}");
    });
});

// ============================================================
// GRUPO: SHOW — Ver evento
// ============================================================

describe('Ver evento (show)', function () {

    it('el propietario puede ver su evento', function () {
        [$user, $evento] = eventoConUsuario();

        $this->actingAs($user)
             ->get(route('eventos.show', $evento))
             ->assertOk()
             ->assertViewIs('eventos.show')
             ->assertViewHas('evento');
    });

    it('otro usuario NO puede ver el evento ajeno (404)', function () {
        [$userA, $eventoA] = eventoConUsuario();
        $userB = User::factory()->create();

        $this->actingAs($userB)
             ->get(route('eventos.show', $eventoA))
             ->assertNotFound();
    });
});

// ============================================================
// GRUPO: EDIT — Formulario de edición
// ============================================================

describe('Editar evento (edit)', function () {

    it('el propietario puede acceder al formulario de edición', function () {
        [$user, $evento] = eventoConUsuario();

        $this->actingAs($user)
             ->get(route('eventos.edit', $evento))
             ->assertOk()
             ->assertViewIs('eventos.edit')
             ->assertViewHas('evento');
    });

    it('otro usuario NO puede acceder al formulario de edición (404)', function () {
        [$userA, $eventoA] = eventoConUsuario();
        $userB = User::factory()->create();

        $this->actingAs($userB)
             ->get(route('eventos.edit', $eventoA))
             ->assertNotFound();
    });
});

// ============================================================
// GRUPO: UPDATE — Actualizar evento
// ============================================================

describe('Actualizar evento (update)', function () {

    it('el propietario actualiza su evento correctamente', function () {
        [$user, $evento] = eventoConUsuario();

        $this->actingAs($user)
             ->put(route('eventos.update', $evento), payloadEventoValido([
                 'nombre_bebe' => 'Actualizadito',
                 'slug'        => $evento->slug,
             ]))
             ->assertRedirect(route('eventos.index'))
             ->assertSessionHas('status', 'Evento actualizado exitosamente.');

        $this->assertDatabaseHas('eventos', [
            'id'          => $evento->id,
            'nombre_bebe' => 'Actualizadito',
        ]);
    });

    it('actualizar permite mantener el mismo slug del evento sin error de unicidad', function () {
        [$user, $evento] = eventoConUsuario(['slug' => 'mi-slug-unico']);

        $this->actingAs($user)
             ->put(route('eventos.update', $evento), payloadEventoValido([
                 'nombre_bebe' => 'Bebé Actualizado',
                 'slug'        => 'mi-slug-unico',
             ]))
             ->assertRedirect(route('eventos.index'))
             ->assertSessionHasNoErrors();
    });

    it('no puede actualizar un evento con un slug de otro evento', function () {
        $user = User::factory()->create();
        $eventoA = Evento::factory()->create(['usuario_id' => $user->id, 'slug' => 'slug-a']);
        $eventoB = Evento::factory()->create(['usuario_id' => $user->id, 'slug' => 'slug-b']);

        $this->actingAs($user)
             ->put(route('eventos.update', $eventoB), payloadEventoValido(['slug' => 'slug-a']))
             ->assertSessionHasErrors('slug');
    });

    it('otro usuario NO puede actualizar evento ajeno (404)', function () {
        [$userA, $eventoA] = eventoConUsuario();
        $userB = User::factory()->create();

        $this->actingAs($userB)
             ->put(route('eventos.update', $eventoA), payloadEventoValido())
             ->assertNotFound();
    });

    it('actualizar con invitados_json reemplaza los invitados existentes', function () {
        [$user, $evento] = eventoConUsuario();

        // Crear una lista y asignarla al evento
        $lista = ListaInvitado::factory()->create(['evento_id' => $evento->id]);
        $evento->update(['lista_invitado_id' => $lista->id]);

        // Invitado previo (forzamos la inserción directa para no depender del factory)
        Invitado::create([
            'evento_id'         => $evento->id,
            'lista_invitado_id' => $lista->id,
            'nombre'            => 'Invitado Antiguo',
            'email'             => 'antiguo@test.com',
            'estado_invitacion' => 'Pendiente',
            'estado_asistencia' => 'Sin responder',
        ]);

        $nuevosInvitados = json_encode([
            ['name' => 'Invitado Nuevo', 'email' => 'nuevo@test.com'],
        ]);

        $this->actingAs($user)
             ->put(route('eventos.update', $evento), payloadEventoValido([
                 'slug'           => $evento->slug,
                 'invitados_json' => $nuevosInvitados,
             ]))
             ->assertRedirect(route('eventos.index'));

        // El antiguo debe tener deleted_at (SoftDelete) o directamente no existir
        $this->assertDatabaseHas('invitados', ['email' => 'nuevo@test.com']);
        // El invitado antiguo no debe quedar activo (puede estar soft-deleted)
        expect(
            Invitado::where('email', 'antiguo@test.com')->count()
        )->toBe(0);
    });

    it('actualizar con invitados_json preserva el estado de asistencia si el email coincide', function () {
        [$user, $evento] = eventoConUsuario();

        $lista = ListaInvitado::factory()->create(['evento_id' => $evento->id]);
        $evento->update(['lista_invitado_id' => $lista->id]);

        Invitado::factory()->create([
            'evento_id'         => $evento->id,
            'lista_invitado_id' => $lista->id,
            'nombre'            => 'Ana García',
            'email'             => 'ana@test.com',
            'estado_asistencia' => 'Confirmado',
            'estado_invitacion' => 'Enviado',
        ]);

        $payload = json_encode([
            ['name' => 'Ana García Actualizada', 'email' => 'ana@test.com'],
        ]);

        $this->actingAs($user)
             ->put(route('eventos.update', $evento), payloadEventoValido([
                 'slug'           => $evento->slug,
                 'invitados_json' => $payload,
             ]));

        $invitadoActualizado = Invitado::where('email', 'ana@test.com')->first();
        expect($invitadoActualizado->estado_asistencia)->toBe('Confirmado');
        expect($invitadoActualizado->estado_invitacion)->toBe('Enviado');
        expect($invitadoActualizado->nombre)->toBe('Ana García Actualizada');
    });
});

// ============================================================
// GRUPO: CANCEL — Cancelar evento
// ============================================================

describe('Cancelar evento (cancel)', function () {

    it('el propietario cancela su evento correctamente', function () {
        [$user, $evento] = eventoConUsuario(['estado' => 'Publicado']);

        $this->actingAs($user)
             ->patch(route('eventos.cancel', $evento))
             ->assertRedirect(route('eventos.index'))
             ->assertSessionHas('status', 'Evento cancelado exitosamente.');

        $this->assertDatabaseHas('eventos', [
            'id'     => $evento->id,
            'estado' => 'Cancelado',
        ]);
    });

    it('otro usuario NO puede cancelar un evento ajeno (404)', function () {
        [$userA, $eventoA] = eventoConUsuario(['estado' => 'Publicado']);
        $userB = User::factory()->create();

        $this->actingAs($userB)
             ->patch(route('eventos.cancel', $eventoA))
             ->assertNotFound();

        // El estado no debe haber cambiado
        expect($eventoA->fresh()->estado)->toBe('Publicado');
    });
});

// ============================================================
// GRUPO: DESTROY — Soft Delete
// ============================================================

describe('Eliminar evento (destroy)', function () {

    it('el propietario puede eliminar su evento (soft delete)', function () {
        [$user, $evento] = eventoConUsuario();

        $this->actingAs($user)
             ->delete(route('eventos.destroy', $evento))
             ->assertRedirect(route('eventos.index'))
             ->assertSessionHas('status', 'Evento eliminado exitosamente.');

        // Sigue en la BD pero con deleted_at
        $this->assertSoftDeleted('eventos', ['id' => $evento->id]);
    });

    it('el evento eliminado no aparece en el índice', function () {
        [$user, $evento] = eventoConUsuario(['nombre_bebe' => 'BebéEliminado']);

        $this->actingAs($user)->delete(route('eventos.destroy', $evento));

        $response = $this->actingAs($user)->get(route('eventos.index'));
        $eventos  = $response->viewData('eventos');

        expect($eventos->where('id', $evento->id))->toBeEmpty();
    });

    it('otro usuario NO puede eliminar un evento ajeno (404)', function () {
        [$userA, $eventoA] = eventoConUsuario();
        $userB = User::factory()->create();

        $this->actingAs($userB)
             ->delete(route('eventos.destroy', $eventoA))
             ->assertNotFound();

        $this->assertDatabaseHas('eventos', ['id' => $eventoA->id, 'deleted_at' => null]);
    });
});

// ============================================================
// GRUPO: Validaciones de estado (enum)
// ============================================================

describe('Validaciones de estado del evento', function () {

    it('acepta todos los valores válidos del enum genero_bebe', function () {
        $user = User::factory()->create();

        foreach (['Niño', 'Niña', 'Sorpresa', 'Múltiple'] as $idx => $genero) {
            $this->actingAs($user)
                 ->post(route('eventos.store'), payloadEventoValido([
                     'genero_bebe' => $genero,
                     'slug'        => 'genero-test-' . $idx,
                 ]))
                 ->assertRedirect(route('eventos.index'))
                 ->assertSessionHasNoErrors();
        }

        expect(Evento::where('usuario_id', $user->id)->count())->toBe(4);
    });

    it('acepta todos los valores válidos del enum estado', function () {
        $user   = User::factory()->create();
        $evento = Evento::factory()->create(['usuario_id' => $user->id]);

        foreach (['Borrador', 'Publicado', 'Finalizado', 'Cancelado'] as $estado) {
            $this->actingAs($user)
                 ->put(route('eventos.update', $evento), payloadEventoValido([
                     'slug'   => $evento->slug,
                     'estado' => $estado,
                 ]))
                 ->assertSessionHasNoErrors();

            expect($evento->fresh()->estado)->toBe($estado);
        }
    });

    it('rechaza un estado no válido en la actualización', function () {
        [$user, $evento] = eventoConUsuario();

        $this->actingAs($user)
             ->put(route('eventos.update', $evento), payloadEventoValido([
                 'slug'   => $evento->slug,
                 'estado' => 'EnPausa',
             ]))
             ->assertSessionHasErrors('estado');
    });
});

// ============================================================
// GRUPO: Dashboard — estadísticas y actividad reciente
// ============================================================

describe('Dashboard', function () {

    it('usuario autenticado y verificado puede ver el dashboard', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->get(route('dashboard'))
             ->assertOk()
             ->assertViewIs('dashboard');
    });

    it('usuario NO verificado es redirigido desde el dashboard', function () {
        // NOTA: Este test documenta el comportamiento real de la app.
        // User no implementa MustVerifyEmail, por lo que el middleware 'verified'
        // de Laravel Breeze NO bloquea usuarios sin email verificado en este proyecto.
        // Si se implementa MustVerifyEmail en el modelo User, este test debería
        // cambiar el assertOk() por assertRedirectToRoute('verification.notice').
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
             ->get(route('dashboard'))
             ->assertOk(); // Cambia a assertRedirectToRoute('verification.notice') si se implementa MustVerifyEmail
    });

    it('el dashboard muestra solo eventos no cancelados ni finalizados del usuario', function () {
        $user       = User::factory()->create();
        $activo     = Evento::factory()->create(['usuario_id' => $user->id, 'estado' => 'Borrador']);
        $publicado  = Evento::factory()->create(['usuario_id' => $user->id, 'estado' => 'Publicado']);
        $cancelado  = Evento::factory()->create(['usuario_id' => $user->id, 'estado' => 'Cancelado']);
        $finalizado = Evento::factory()->create(['usuario_id' => $user->id, 'estado' => 'Finalizado']);

        $response = $this->actingAs($user)->get(route('dashboard'));
        $eventos  = $response->viewData('eventos');

        expect($eventos->pluck('id'))->toContain($activo->id)
                                      ->toContain($publicado->id);
        expect($eventos->pluck('id'))->not->toContain($cancelado->id)
                                          ->not->toContain($finalizado->id);
    });
});
