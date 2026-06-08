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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function regalos()
    {
        return $this->hasMany(Regalo::class, 'lista_regalos_id');
    }
}
