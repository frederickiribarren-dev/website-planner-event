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
        'lista_invitado_id',
        'lista_regalos_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function listaInvitado()
    {
        return $this->belongsTo(ListaInvitado::class, 'lista_invitado_id');
    }

    public function listaRegalo()
    {
        return $this->belongsTo(ListaRegalo::class, 'lista_regalos_id');
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

    public function listasRegalos()
    {
        return $this->hasMany(ListaRegalo::class, 'evento_id');
    }
    
}