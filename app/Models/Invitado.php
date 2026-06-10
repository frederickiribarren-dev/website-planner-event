<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'evento_id',
        'lista_invitado_id',
        'nombre',
        'email',
        'telefono',
        'token_acceso',
        'estado_invitacion',
        'estado_asistencia',
        'cantidad_adultos',
        'cantidad_ninos',
        'alergias_notas',
        'fecha_confirmacion',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function listaInvitado()
    {
        return $this->belongsTo(ListaInvitado::class, 'lista_invitado_id');
    }
}
