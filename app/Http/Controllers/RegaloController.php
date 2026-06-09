<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Regalo;
use App\Models\ListaRegalo;
use App\Models\CategoriaRegalo;
use App\Models\Evento;

class RegaloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Traemos las categorías con sus regalos base (el catálogo maestro donde lista_regalos_id es null)
        $categoriasBD = CategoriaRegalo::with(['regalos' => function($query) {
            $query->whereNull('lista_regalos_id');
        }])->get();

        // Convertimos al formato estructural de tu JSON original para no romper el JS
        $categorias = [];
        foreach ($categoriasBD as $cat) {
            // Si en el JS usas "Grupales" en vez de "Grupal", lo mapeamos aquí
            $nombreKey = ($cat->nombre === 'Grupal') ? 'Grupales' : $cat->nombre;
            $categorias[$nombreKey] = $cat->regalos->map(function($regalo) {
                return [
                    'id' => $regalo->id,
                    'nombre' => $regalo->nombre_regalo,
                    'descripcion' => $regalo->descripcion,
                    'imagen_portada_url' => $regalo->imagen_portada_url,
                    'prioridad' => $regalo->prioridad,
                    'estado' => $regalo->estado,
                ];
            })->toArray();
        }

        // 2. Traemos los eventos del usuario autenticado
        $eventos = auth()->user()->eventos()->get();

        // 3. Traemos las listas del usuario con sus copias privadas de regalos cargadas
        $listasRegalos = auth()->user()->listasRegalos()->with('regalos.categoria')->get();

        return view('regalos.creacion-lista-regalos', [
            'categorias' => $categorias,
            'eventos' => $eventos,
            'listasRegalos' => $listasRegalos,
        ]);
    } // <-- Se eliminó la llave extra que rompía el archivo aquí

    /**
     * Store a newly created gift (personalizado).
     */
    public function storeGift(Request $request)
    {
        $validated = $request->validate([
            'nombre_regalo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|in:Ropa,Utensilios,Accesorios,Grupal,Grupales',
            'link_referencia' => 'nullable|string|max:500',
            'link_referencia_2' => 'nullable|string|max:500',
            'link_referencia_3' => 'nullable|string|max:500',
            'precio_estimado' => 'nullable|numeric|min:0',
            'cantidad_solicitada' => 'nullable|integer|min:1',
            'imagen_portada_url' => 'nullable|string|max:5000',
            'lista_regalos_id' => 'nullable|exists:listas_regalos,id',
        ]);

        // Mapeamos el nombre de la categoría del JS al ENUM real de la base de datos ('Grupal')
        $nombreCat = ($validated['categoria'] === 'Grupales') ? 'Grupal' : $validated['categoria'];
        $categoriaBD = CategoriaRegalo::where('nombre', $nombreCat)->firstOrFail();

        // Si se crea directo desde una lista existente, heredamos su evento_id automáticamente
        $eventoId = null;
        if (!empty($validated['lista_regalos_id'])) {
            $listaDef = ListaRegalo::find($validated['lista_regalos_id']);
            if ($listaDef) {
                $eventoId = $listaDef->evento_id;
            }
        }

        $regalo = Regalo::create([
            'nombre_regalo' => $validated['nombre_regalo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'categoria_id' => $categoriaBD->id, // Guardamos el ID numérico correspondiente
            'lista_regalos_id' => $validated['lista_regalos_id'] ?? null,
            'evento_id' => $eventoId,
            'link_referencia' => $validated['link_referencia'] ?? null,
            'link_referencia_2' => $validated['link_referencia_2'] ?? null,
            'link_referencia_3' => $validated['link_referencia_3'] ?? null,
            'precio_estimado' => $validated['precio_estimado'] ?? null,
            'cantidad_solicitada' => $validated['cantidad_solicitada'] ?? 1,
            'imagen_portada_url' => $validated['imagen_portada_url'] ?? null,
            'estado' => 'Disponible',
            'prioridad' => 'Media',
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
            'estado' => 'Borrador', // Cambiado a 'Borrador' según la lógica estándar de tu tabla
        ]);

        // Se replica el ítem base del catálogo para evitar alterar el maestro
        foreach ($validated['regalos_ids'] as $idRegaloCatalogo) {
            $regaloPlantilla = Regalo::find($idRegaloCatalogo);
            
            if ($regaloPlantilla) {
                $regaloUsuario = $regaloPlantilla->replicate();

                // CORREGIDO: Se cambiaron los nombres de las propiedades a los campos reales de tu migración
                $regaloUsuario->lista_regalos_id = $listaRegalo->id;
                $regaloUsuario->evento_id = $listaRegalo->evento_id;
                $regaloUsuario->cantidad_solicitada = 1; // Cantidad base por defecto al clonar masivo

                $regaloUsuario->save();
            }
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
            'qty' => 'nullable|integer|min:1', // Añadido soporte para capturar la cantidad del modal
        ]);

        // Verify ownership
        if ($listaRegalo->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta lista.',
            ], 403);
        }

        $regaloPlantilla = Regalo::find($validated['regalo_id']);
        
        if ($regaloPlantilla) {
            $regaloUsuario = $regaloPlantilla->replicate();
            
            // CORREGIDO: Ajustado a las propiedades de tu esquema original
            $regaloUsuario->lista_regalos_id = $listaRegalo->id;
            $regaloUsuario->evento_id = $listaRegalo->evento_id; 
            $regaloUsuario->cantidad_solicitada = $validated['qty'] ?? 1;
            
            $regaloUsuario->save();
        }

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
            'regalos' => 'required|array',
            'regalos.*.regalocatalogo' => 'required|integer|exists:regalos,id',
            'regalos.*.qty' => 'required|integer|min:1'
        ]);

        $listaRegalo->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'evento_id' => $validated['evento_id'] ?? null,
        ]);

        $listaRegalo -> regalos()-> delete();

        if (!empty($request->regalos)) {
        foreach ($request->regalos as $item) {
            
            $idRegalo = $item['regalocatalogo'];
            $cantidad = $item['qty'];

            $regaloPlantilla = Regalo::find($idRegalo);

            if ($regaloPlantilla) {
                $regaloUsuario = $regaloPlantilla->replicate();

                $regaloUsuario->lista_regalos_id = $listaRegalo->id;
                $regaloUsuario->evento_id = $listaRegalo->evento_id;
                
                
                $regaloUsuario->cantidad_solicitada = $cantidad;
                
                $regaloUsuario->save();
            }
        }
    }

        return response()->json([
            'success' => true,
            'message' => 'Lista de regalos actualizada.',
            'lista' => $listaRegalo->load('regalos'),
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