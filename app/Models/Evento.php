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

    public function regalos()
    {
        return $this->hasMany(Regalo::class, 'evento_id');
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'evento_id');
    }

    public function listasInvitados()
    {
        return $this->hasMany(ListaInvitado::class, 'evento_id');
    }
}
