<?php

use App\Models\CategoriaRegalo;
use App\Models\ListaRegalo;
use App\Models\Regalo;
use App\Models\User;

test('user can create a gift list with items from the catalog', function () {
    $user = User::factory()->create();

    $categoria = CategoriaRegalo::create(['nombre' => 'Ropa']);

    $regaloCatalogo = Regalo::create([
        'categoria_id' => $categoria->id,
        'nombre_regalo' => 'Bodies de algodón',
        'lista_regalos_id' => null,
        'evento_id' => null,
        'estado' => 'Disponible',
        'prioridad' => 'Media',
    ]);

    $response = $this->actingAs($user)->postJson(route('listas-regalos.store'), [
        'nombre' => 'Lista del bebé',
        'descripcion' => 'Regalos básicos',
        'regalos' => [
            [
                'regalocatalogo' => $regaloCatalogo->id,
                'qty' => 2,
            ],
        ],
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
            'message' => 'Lista de regalos creada exitosamente.',
        ]);

    $lista = ListaRegalo::where('user_id', $user->id)->first();

    expect($lista)->not->toBeNull()
        ->and($lista->nombre)->toBe('Lista del bebé')
        ->and($lista->estado)->toBe('Borrador')
        ->and($lista->regalos)->toHaveCount(1)
        ->and($lista->regalos->first()->nombre_regalo)->toBe('Bodies de algodón')
        ->and($lista->regalos->first()->cantidad_solicitada)->toBe(2);
});
