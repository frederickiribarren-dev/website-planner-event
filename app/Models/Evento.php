<?php

namespace App\Models;

use Database\Factories\EventoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    /** @use HasFactory<EventoFactory> */
    use HasFactory, SoftDeletes;
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

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el evento y su creador (Usuario).
     *
     * Asocia el evento con el modelo de usuario a través de la clave foránea 'usuario_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia el creador del evento.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el evento y su lista de invitados principal.
     *
     * Asocia el evento con la lista de invitados principal mediante la clave foránea 'lista_invitado_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia la lista de invitados principal.
     */
    public function listaInvitado()
    {
        return $this->belongsTo(ListaInvitado::class, 'lista_invitado_id');
    }

    /**
     * Define la relación "pertenece a" (BelongsTo) entre el evento y su lista de regalos principal.
     *
     * Asocia el evento con la lista de regalos principal utilizando la clave foránea 'lista_regalos_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia la lista de regalos principal.
     */
    public function listaRegalo()
    {
        return $this->belongsTo(ListaRegalo::class, 'lista_regalos_id');
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre el evento y los regalos que contiene.
     *
     * Permite asociar y consultar todos los registros de regalos relacionados con el evento mediante
     * la clave foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relación con los regalos individuales.
     */
    public function regalos()
    {
        return $this->hasMany(Regalo::class, 'evento_id');
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre el evento y los invitados directos.
     *
     * Permite consultar la colección completa de invitados agregados al evento mediante la clave
     * foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relación con los invitados directos.
     */
    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'evento_id');
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre el evento y las listas de invitados creadas en él.
     *
     * Permite obtener todas las agrupaciones de listas de invitados ligadas al evento a través
     * de la clave foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relación con las listas de invitados del evento.
     */
    public function listasInvitados()
    {
        return $this->hasMany(ListaInvitado::class, 'evento_id');
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre el evento y las listas de regalos creadas en él.
     *
     * Permite recuperar todas las listas de regalos asignadas o ligadas al evento por medio de
     * la clave foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relación con las listas de regalos del evento.
     */
    public function listasRegalos()
    {
        return $this->hasMany(ListaRegalo::class, 'evento_id');
    }
}