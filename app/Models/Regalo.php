<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regalo extends Model
{
    //
    protected $fillable = [
        'evento_id',
        'categoria_id',
        'nombre',
        'descripcion',
        'url_imagen',
        'url_compra',
        'estado',
    ];

    //categoria
    public function categoria()
    {
        return $this->belongsTo(CategoriaRegalo::class, 'categoria_id');   
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }


}

