<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaRegalo extends Model
{
    // Le indicamos a Laravel el nombre exacto de tu tabla de la migración
    protected $table = 'categorias_regalos';

    // Permitimos la asignación masiva del campo nombre
    protected $fillable = [
        'nombre',
        'icono_url',
    ];

    /**
     * Relación: Una categoría tiene muchos regalos asociados en el catálogo.
     */
    public function regalos()
    {
        return $this->hasMany(Regalo::class, 'categoria_id');
    }
}