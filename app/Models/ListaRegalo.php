<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaRegalo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'listas_regalos';

    protected $fillable = [
        'user_id',
        'evento_id',
        'nombre',
        'descripcion',
        'estado',
    ];

    /**
     * Define la relación "pertenece a" (BelongsTo) entre la lista de regalos y el usuario creador.
     *
     * Asocia la lista de regalos con el usuario a través de la clave foránea 'user_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia el usuario creador.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define la relación "pertenece a" (BelongsTo) entre la lista de regalos y el evento asignado.
     *
     * Permite asociar opcionalmente la lista de regalos con un evento mediante la clave foránea 'evento_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Relación hacia el evento asociado.
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre la lista de regalos y los regalos individuales.
     *
     * Permite consultar todos los regalos asociados a esta lista de regalos mediante la clave
     * foránea 'lista_regalos_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Relación con los regalos de la lista.
     */
    public function regalos()
    {
        return $this->hasMany(Regalo::class, 'lista_regalos_id');
    }
}
