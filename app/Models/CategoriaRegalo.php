<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaRegalo extends Model
{
    protected $table = 'categorias_regalos';

    protected $fillable = [
        'nombre',
        'icono_url',
    ];

    /**
     * Define la relación "uno a muchos" (HasMany) entre la categoría y los regalos que pertenecen a ella.
     *
     * Permite consultar la colección de regalos asociados a esta categoría mediante la clave foránea 'categoria_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relación con los regalos de la categoría.
     */
    public function regalos()
    {
        return $this->hasMany(Regalo::class, 'categoria_id');
    }
}