<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    //
    protected $fillable = [
        'usuario_id',
        'slug',
        'nombre_bebe',
        'genero_bebe',
        'fecha_evento',
        'ubicacion_nombre',
        'lat',
        'lng',
        'mensaje_invitacion',
        'color_tema',
        'estado',
        'imagen_portada_url',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
