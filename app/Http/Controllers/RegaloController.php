<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regalo;
use App\Models\ListaRegalo;
use App\Models\Evento;

class RegaloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jsonPath = resource_path('data/item-regalos.json');
        $jsonData = json_decode(file_get_contents($jsonPath), true);

        $eventos = auth()->user()->eventos()->get();
        $listasRegalos = auth()->user()->listasRegalos()->with('regalos')->get();

        return view('regalos.creacion-lista-regalos', [
            'categorias' => $jsonData['categorias'] ?? [],
            'eventos' => $eventos,
            'listasRegalos' => $listasRegalos,
        ]);
    }

    /**
     * Store a newly created gift (personalizado).
     */
    public function storeGift(Request $request)
    {
        $validated = $request->validate([
            'nombre_regalo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|in:Ropa,Utensilios,Accesorios,Grupal',
            'link_referencia' => 'nullable|string|max:500',
            'link_referencia_2' => 'nullable|string|max:500',
            'link_referencia_3' => 'nullable|string|max:500',
            'precio_estimado' => 'nullable|numeric|min:0',
            'cantidad_solicitada' => 'nullable|integer|min:1',
            'imagen_portada_url' => 'nullable|string|max:5000',
        ]);

        $regalo = Regalo::create([
            'nombre_regalo' => $validated['nombre_regalo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'link_referencia' => $validated['link_referencia'] ?? null,
            'link_referencia_2' => $validated['link_referencia_2'] ?? null,
            'link_referencia_3' => $validated['link_referencia_3'] ?? null,
            'precio_estimado' => $validated['precio_estimado'] ?? null,
            'cantidad_solicitada' => $validated['cantidad_solicitada'] ?? 1,
            'imagen_portada_url' => $validated['imagen_portada_url'] ?? null,
            'estado' => 'Disponible',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Regalo creado exitosamente.',
            'gift' => $regalo,
        ]);
    }

    /**
     * Create a new gift list.
     */
    public function storeLista(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'evento_id' => 'nullable|exists:eventos,id',
            'regalos_ids' => 'required|array|min:1',
            'regalos_ids.*' => 'integer|exists:regalos,id',
        ]);

        $listaRegalo = ListaRegalo::create([
            'user_id' => auth()->id(),
            'evento_id' => $validated['evento_id'] ?? null,
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'estado' => 'Activa',
        ]);

        // Associate gifts to the list
        foreach ($validated['regalos_ids'] as $regaloId) {
            Regalo::find($regaloId)->update(['lista_regalos_id' => $listaRegalo->id]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lista de regalos creada exitosamente.',
            'lista' => $listaRegalo->load('regalos'),
        ]);
    }

    /**
     * Add gift to existing list.
     */
    public function addToList(Request $request, ListaRegalo $listaRegalo)
    {
        $validated = $request->validate([
            'regalo_id' => 'required|exists:regalos,id',
        ]);

        // Verify ownership
        if ($listaRegalo->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta lista.',
            ], 403);
        }

        Regalo::find($validated['regalo_id'])->update(['lista_regalos_id' => $listaRegalo->id]);

        return response()->json([
            'success' => true,
            'message' => 'Regalo añadido a la lista.',
        ]);
    }

    /**
     * Update gift list (assign to event or change name).
     */
    public function updateLista(Request $request, ListaRegalo $listaRegalo)
    {
        if ($listaRegalo->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta lista.',
            ], 403);
        }

        $validated = $request->validate([
            'nombre' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
            'evento_id' => 'nullable|exists:eventos,id',
        ]);

        $listaRegalo->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lista de regalos actualizada.',
            'lista' => $listaRegalo,
        ]);
    }

    /**
     * Delete gift list.
     */
    public function destroyLista(ListaRegalo $listaRegalo)
    {
        if ($listaRegalo->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para eliminar esta lista.',
            ], 403);
        }

        $listaRegalo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lista de regalos eliminada.',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
