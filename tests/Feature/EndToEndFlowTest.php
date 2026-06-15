<?php

use App\Models\CategoriaRegalo;
use App\Models\Evento;
use App\Models\ListaInvitado;
use App\Models\ListaRegalo;
use App\Models\Regalo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('flujo completo: registro, login, crear evento, listas y regalo', function () {
    // 1. Crear Usuario (Registro)
    $responseRegistro = $this->post('/register', [
        'name' => 'Usuario Prueba E2E',
        'email' => 'e2e@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $responseRegistro->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticated();

    // Hacemos logout para probar el login explícitamente
    $this->post('/logout');
    $this->assertGuest();

    // 2. Login
    $responseLogin = $this->post('/login', [
        'email' => 'e2e@example.com',
        'password' => 'password123',
    ]);

    $responseLogin->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticated();

    $user = User::where('email', 'e2e@example.com')->first();

    // 3. Crear Evento
    $responseEvento = $this->actingAs($user)->post(route('eventos.store'), [
        'slug' => 'baby-shower-e2e',
        'nombre_bebe' => 'Bebé E2E',
        'genero_bebe' => 'Sorpresa',
        'fecha_evento' => now()->addMonth()->format('Y-m-d'),
        'ubicacion_nombre' => 'Salón de Fiestas',
    ]);

    $responseEvento->assertRedirect(route('eventos.index'));
    $evento = Evento::where('slug', 'baby-shower-e2e')->first();
    expect($evento)->not->toBeNull();

    // 4. Crear Lista de Invitados
    $responseListaInvitados = $this->actingAs($user)->post(route('eventos.listas-invitados.store', $evento), [
        'nombre' => 'Amigos del Trabajo',
        'categoria' => 'Amigos',
    ]);

    $responseListaInvitados->assertRedirect(route('eventos.listas-invitados.index', $evento));
    $listaInvitados = ListaInvitado::where('evento_id', $evento->id)->first();
    expect($listaInvitados)->not->toBeNull()->and($listaInvitados->nombre)->toBe('Amigos del Trabajo');

    // 5. Crear Lista de Regalos (requiere categoría y regalo maestro en el catálogo)
    $categoria = CategoriaRegalo::firstOrCreate(['nombre' => 'Ropa']);
    $regaloCatalogo = Regalo::create([
        'categoria_id' => $categoria->id,
        'nombre_regalo' => 'Set de bodies E2E',
        'lista_regalos_id' => null,
        'evento_id' => null,
        'estado' => 'Disponible',
        'prioridad' => 'Media',
    ]);

    $responseListaRegalos = $this->actingAs($user)->postJson(route('listas-regalos.store'), [
        'nombre' => 'Lista E2E',
        'descripcion' => 'Regalos para el bebé E2E',
        'evento_id' => $evento->id,
        'regalos' => [
            [
                'regalocatalogo' => $regaloCatalogo->id,
                'qty' => 3,
            ],
        ],
    ]);

    $responseListaRegalos->assertOk();
    $listaRegalos = ListaRegalo::where('evento_id', $evento->id)->first();
    expect($listaRegalos)->not->toBeNull()->and($listaRegalos->nombre)->toBe('Lista E2E');

    // 6. Crear un Regalo Personalizado (Fuera del catálogo, agregado por el usuario)
    CategoriaRegalo::firstOrCreate(['nombre' => 'Accesorios']);
    
    $responseRegalo = $this->actingAs($user)->postJson(route('regalos.store'), [
        'nombre_regalo' => 'Cochecito E2E',
        'descripcion' => 'Cochecito de 3 ruedas',
        'categoria' => 'Accesorios', // Asegúrate de que exista esta categoría
        'precio_estimado' => 150000,
        'cantidad_solicitada' => 1,
        'lista_regalos_id' => $listaRegalos->id,
    ]);

    $responseRegalo->assertOk();
    
    // Verificamos en base de datos
    $this->assertDatabaseHas('regalos', [
        'nombre_regalo' => 'Cochecito E2E',
        'lista_regalos_id' => $listaRegalos->id,
    ]);
});
