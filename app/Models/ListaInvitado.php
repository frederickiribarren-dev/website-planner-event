<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaInvitado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'listas_invitados';

    protected $fillable = [
        'evento_id',
        'nombre',
        'categoria',
    ];

    /**
     * Define la relación "pertenece a" (BelongsTo) entre la lista de invitados y su evento asignado.
     *
     * Vincula la lista de invitados con el evento correspondiente mediante la clave foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia el evento asociado.
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre la lista de invitados y sus integrantes (Invitados).
     *
     * Permite consultar la colección de todos los invitados individuales agrupados bajo esta lista específica
     * a través de la clave foránea 'lista_invitado_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relación con los invitados de la lista.
     */
    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'lista_invitado_id');
    }
}
