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
     * Muestra la interfaz general para la creación de listas de regalos.
     *
     * Recupera las categorías de regalos junto con sus regalos base predeterminados, los eventos
     * activos del usuario autenticado y las listas de regalos guardadas del usuario con sus 
     * respectivos detalles de regalos asignados. Retorna la vista 'regalos.creacion-lista-regalos'.
     *
     * @return \Illuminate\View\View Vista para administrar y crear listas de regalos.
     */
    public function index()
    {
        $categoriasBD = CategoriaRegalo::with(['regalos' => function($query) {
            $query->whereNull('lista_regalos_id');
        }])->get();

        $categorias = [];
        foreach ($categoriasBD as $cat) {
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

        $eventos = auth()->user()->eventos()->get();

        $listasRegalos = auth()->user()->listasRegalos()->with('regalos.categoria')->get();

        return view('regalos.creacion-lista-regalos', [
            'categorias' => $categorias,
            'eventos' => $eventos,
            'listasRegalos' => $listasRegalos,
        ]);
    }

    /**
     * Almacena un regalo nuevo y personalizado (creado directamente por el usuario).
     *
     * Valida los parámetros del regalo (nombre, descripción, categoría, enlaces de referencia,
     * precio estimado, cantidad solicitada e imagen). Obtiene la categoría correspondiente en la
     * base de datos, almacena el archivo de imagen en el disco público si se proporciona, y crea el 
     * regalo asociándolo opcionalmente a una lista y evento. Retorna una respuesta JSON.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información del regalo.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la operación y el regalo creado.
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
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
            'lista_regalos_id' => 'nullable|exists:listas_regalos,id',
        ]);

        $nombreCat = ($validated['categoria'] === 'Grupales') ? 'Grupal' : $validated['categoria'];
        $categoriaBD = CategoriaRegalo::where('nombre', $nombreCat)->firstOrFail();

        $eventoId = null;
        if (!empty($validated['lista_regalos_id'])) {
            $listaDef = ListaRegalo::find($validated['lista_regalos_id']);
            if ($listaDef) {
                $eventoId = $listaDef->evento_id;
            }
        }

        $rutaImagen = null;
        if ($request->hasFile('imagen_portada')) {
            $rutaImagen = $request->file('imagen_portada')->store('regalos', 'public');
        }

        $regalo = Regalo::create([
            'nombre_regalo' => $validated['nombre_regalo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'categoria_id' => $categoriaBD->id, 
            'lista_regalos_id' => $validated['lista_regalos_id'] ?? null,
            'evento_id' => $eventoId,
            'link_referencia' => $validated['link_referencia'] ?? null,
            'link_referencia_2' => $validated['link_referencia_2'] ?? null,
            'link_referencia_3' => $validated['link_referencia_3'] ?? null,
            'precio_estimado' => $validated['precio_estimado'] ?? null,
            'cantidad_solicitada' => $validated['cantidad_solicitada'] ?? 1,
            'imagen_portada_url' => $rutaImagen, 
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
     * Crea una nueva lista de regalos y asocia regalos replicados a partir del catálogo maestro.
     *
     * Valida el nombre, descripción y el evento asociado a la lista, así como un array de regalos
     * que contiene las referencias al catálogo maestro y sus cantidades/enlaces personalizados.
     * Crea la lista de regalos con estado inicial 'Borrador' y replica cada regalo del catálogo maestro,
     * asignándolo a la lista recién creada. Retorna el resultado en JSON.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con los datos de la lista y regalos.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON confirmando la creación e incluyendo la lista.
     */
    public function storeLista(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'evento_id' => 'nullable|exists:eventos,id',
            'regalos' => 'required|array|min:1',
            'regalos.*.regalocatalogo' => 'required|integer|exists:regalos,id',
            'regalos.*.qty' => 'required|integer|min:1',
            'regalos.*.link_referencia' => 'nullable|string|max:500',
            'regalos.*.link_referencia_2' => 'nullable|string|max:500',
            'regalos.*.link_referencia_3' => 'nullable|string|max:500',
        ]);

        $listaRegalo = ListaRegalo::create([
            'user_id' => auth()->id(),
            'evento_id' => $validated['evento_id'] ?? null,
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'estado' => 'Borrador', 
        ]);

        if (!empty($request->regalos)) {
            foreach ($request->regalos as $item) {
                $idRegaloCatalogo = $item['regalocatalogo'];
                $cantidad = $item['qty'];

                $regaloPlantilla = Regalo::find($idRegaloCatalogo);
                
                if ($regaloPlantilla) {
                    $regaloUsuario = $regaloPlantilla->replicate();

                    $regaloUsuario->lista_regalos_id = $listaRegalo->id;
                    $regaloUsuario->evento_id = $listaRegalo->evento_id;
                    $regaloUsuario->cantidad_solicitada = $cantidad; 

                    $regaloUsuario->link_referencia = $item['link_referencia'] ?? null;
                    $regaloUsuario->link_referencia_2 = $item['link_referencia_2'] ?? null;
                    $regaloUsuario->link_referencia_3 = $item['link_referencia_3'] ?? null;

                    $regaloUsuario->save();
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Lista de regalos creada exitosamente.',
            'lista' => $listaRegalo->load('regalos'),
        ]);
    }

    /**
     * Agrega un regalo individual del catálogo maestro a una lista existente de regalos.
     *
     * Valida el regalo y la cantidad solicitada. Comprueba que el usuario autenticado sea el dueño
     * de la lista de regalos. Replica el regalo de plantilla, asignándolo a la lista de regalos y 
     * guardando la cantidad indicada. Retorna respuesta en formato JSON.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con el ID de regalo y cantidad.
     * @param \App\Models\ListaRegalo $listaRegalo Lista de regalos seleccionada.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la operación.
     */
    public function addToList(Request $request, ListaRegalo $listaRegalo)
    {
        $validated = $request->validate([
            'regalo_id' => 'required|exists:regalos,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        if ($listaRegalo->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta lista.',
            ], 403);
        }

        $regaloPlantilla = Regalo::find($validated['regalo_id']);
        
        if ($regaloPlantilla) {
            $regaloUsuario = $regaloPlantilla->replicate();
            
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
     * Actualiza la información general y la lista de regalos asociados a una lista existente.
     *
     * Verifica la pertenencia de la lista al usuario autenticado. Valida los campos de la lista y los
     * nuevos regalos a asociar. Actualiza el nombre, descripción y evento. Limpia todos los registros
     * de regalos asociados previamente a la lista y re-crea cada regalo del catálogo maestro con los
     * nuevos detalles. Retorna la respuesta en formato JSON.
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP con la información de actualización.
     * @param \App\Models\ListaRegalo $listaRegalo Lista de regalos a modificar.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con el resultado de la operación.
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
            'regalos.*.qty' => 'required|integer|min:1',
            'regalos.*.link_referencia' => 'nullable|string|max:500',
            'regalos.*.link_referencia_2' => 'nullable|string|max:500',
            'regalos.*.link_referencia_3' => 'nullable|string|max:500',
        ]);

        $listaRegalo->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'evento_id' => $validated['evento_id'] ?? null,
        ]);

        $listaRegalo->regalos()->delete();

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

                    $regaloUsuario->link_referencia = $item['link_referencia'] ?? null;
                    $regaloUsuario->link_referencia_2 = $item['link_referencia_2'] ?? null;
                    $regaloUsuario->link_referencia_3 = $item['link_referencia_3'] ?? null;
                    
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
     * Elimina una lista de regalos específica del almacenamiento de la base de datos.
     *
     * Valida la propiedad de la lista con respecto al usuario actual, ejecuta el método delete
     * en el modelo y devuelve una respuesta confirmando la eliminación en formato JSON.
     *
     * @param \App\Models\ListaRegalo $listaRegalo Instancia de la lista de regalos a eliminar.
     * @return \Illuminate\Http\JsonResponse Respuesta JSON indicando el éxito de la operación.
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
     * Muestra el formulario para crear un recurso de regalos individual. (Función de recurso no utilizada).
     *
     * @return void
     */
    public function create()
    {
    }

    /**
     * Muestra los detalles de un recurso de regalo individual. (Función de recurso no utilizada).
     *
     * @param string $id Identificador del regalo.
     * @return void
     */
    public function show(string $id)
    {
    }

    /**
     * Muestra el formulario de edición de un recurso de regalo individual. (Función de recurso no utilizada).
     *
     * @param string $id Identificador del regalo.
     * @return void
     */
    public function edit(string $id)
    {
    }

    /**
     * Actualiza un recurso de regalo individual en el almacenamiento. (Función de recurso no utilizada).
     *
     * @param \Illuminate\Http\Request $request Solicitud HTTP.
     * @param string $id Identificador del regalo.
     * @return void
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remueve un recurso de regalo individual del almacenamiento. (Función de recurso no utilizada).
     *
     * @param string $id Identificador del regalo.
     * @return void
     */
    public function destroy(string $id)
    {
    }   

    /**
     * Muestra la interfaz de propuestas de regalos (Sección próximamente).
     *
     * Retorna una vista informativa indicando que la sección de propuestas de regalos
     * estará disponible próximamente en la plataforma.
     *
     * @return \Illuminate\View\View Vista temporal de la sección próximamente.
     */
    public function propuestas()
    {
        return view('regalos.propuestas-proximamente');
    }
}