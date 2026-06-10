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

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el invitado y su evento asociado.
     *
     * Vincula el registro del invitado con el evento correspondiente mediante la clave foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia el evento asociado.
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el invitado y la lista de invitados a la que pertenece.
     *
     * Asocia al invitado con una lista de invitados específica mediante la clave foránea 'lista_invitado_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia la lista de invitados asociada.
     */
    public function listaInvitado()
    {
        return $this->belongsTo(ListaInvitado::class, 'lista_invitado_id');
    }
}
