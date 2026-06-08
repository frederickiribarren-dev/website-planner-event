<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regalo extends Model
{
    //
    protected $fillable = [
        'evento_id',
        'lista_regalos_id',
        'categoria_id',
        'nombre_regalo',
        'descripcion',
        'prioridad',
        'link_referencia',
        'link_referencia_2',
        'link_referencia_3',
        'precio_estimado',
        'cantidad_solicitada',
        'cantidad_completada',
        'estado',
        'imagen_portada_url',
    ];

    //...existing code...

    public function listaRegalo()
    {
        return $this->belongsTo(ListaRegalo::class, 'lista_regalos_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }


}

