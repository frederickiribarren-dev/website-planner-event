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

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'lista_invitado_id');
    }
}
