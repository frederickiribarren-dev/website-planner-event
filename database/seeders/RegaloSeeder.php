<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Regalo;

// IMPORTANTE: Asegúrate de tener el modelo creado para tu tabla de categorías
// Si tu modelo se llama de otra forma, ajústalo aquí.
use App\Models\CategoriaRegalo; 

class RegaloSeeder extends Seeder
{
    public function run(): void
    {
        // --- PASO 1: CREAR LAS CATEGORÍAS ---
        $nombresCategorias = ['Ropa', 'Utensilios', 'Accesorios', 'Grupal'];
        $categoriasBD = [];

        foreach ($nombresCategorias as $nombre) {
            // firstOrCreate evita duplicados si corres el seeder dos veces
            $categoriasBD[$nombre] = CategoriaRegalo::firstOrCreate(['nombre' => $nombre]);
        }

        // --- PASO 2: LEER EL JSON ---
        $jsonPath = resource_path('data/item-regalos.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error('No se encontró el JSON en: ' . $jsonPath);
            return;
        }

        $json = json_decode(File::get($jsonPath), true);
        $categoriasJson = $json['categorias'] ?? [];

        // --- PASO 3: INSERTAR REGALOS DEL CATÁLOGO ---
        foreach ($categoriasJson as $nombreCategoria => $items) {
            
            // Corrección al vuelo: Si el JSON dice "Grupales", lo tratamos como "Grupal"
            $nombreCorregido = ($nombreCategoria === 'Grupales') ? 'Grupal' : $nombreCategoria;
            
            // Obtenemos el ID real de la base de datos (1, 2, 3 o 4)
            $categoriaId = $categoriasBD[$nombreCorregido]->id;

            foreach ($items as $item) {
                Regalo::create([
                    // Son "plantillas" del catálogo, no tienen lista ni evento
                    'evento_id' => null, 
                    'lista_regalos_id' => null,
                    'categoria_id' => $categoriaId, 
                    
                    'nombre_regalo' => $item['nombre'],
                    'descripcion' => $item['descripcion'] ?? null,
                    'imagen_portada_url' => empty($item['imagen_portada_url']) ? null : $item['imagen_portada_url'],
                    
                    // Valores por defecto de tu migración
                    'prioridad' => 'Media',
                    'estado' => 'Disponible',
                    'cantidad_solicitada' => 1,
                    'cantidad_completada' => 0,
                    
                    'created_at' => isset($item['created_at']) ? $item['created_at'] . ' 00:00:00' : now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('¡Categorías y catálogo de regalos importados con éxito!');
    }
}