<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * El tipo de clave primaria.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indica si el ID es autoincremental.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',     // Alias para 'nombre'
        'email',
        'password', // Alias para 'password_hash'
        'nombre',
        'password_hash',
        'telefono',
        'estado',
        'imagen_portada_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_hash' => 'hashed',
        ];
    }

    /**
     * Obtener el nombre de la columna de contraseña para la autenticación.
     *
     * @return string
     */
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    /**
     * Alias para el atributo 'nombre' para compatibilidad con Breeze.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nombre,
            set: fn (string $value) => [
                'nombre' => $value,
            ],
        );
    }

    /**
     * Alias para el atributo 'password_hash' para compatibilidad con Breeze.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => [
                'password_hash' => $value,
            ],
        );
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'usuario_id');
    }

    public function listasRegalos()
    {
        return $this->hasMany(ListaRegalo::class, 'user_id');
    }

    
}
