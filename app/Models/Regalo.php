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

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el regalo y la lista de regalos contenedora.
     *
     * Vincula el regalo con una lista de regalos mediante la clave foránea 'lista_regalos_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia la lista de regalos asociada.
     */
    public function listaRegalo()
    {
        return $this->belongsTo(ListaRegalo::class, 'lista_regalos_id');
    }

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el regalo y el evento.
     *
     * Permite asociar de forma opcional el regalo directamente con un evento mediante la clave
     * foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia el evento asociado.
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el regalo y su categoría asignada.
     *
     * Vincula el regalo con su categoría correspondiente mediante la clave foránea 'categoria_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia la categoría asociada.
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaRegalo::class, 'categoria_id');
    }
}

