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
     * Define las conversiones de tipo (casting) de los atributos del modelo.
     *
     * Asigna tipos específicos a columnas como 'email_verified_at' (fecha y hora) y
     * 'password_hash' (hash seguro de contraseña) para que Eloquent los trate adecuadamente.
     *
     * @return array<string, string> Reglas de casting del modelo.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_hash' => 'hashed',
        ];
    }

    /**
     * Obtiene el nombre del atributo que contiene la contraseña hash para la autenticación.
     *
     * Devuelve el nombre de la columna personalizada 'password_hash' en lugar del valor
     * predeterminado de Laravel ('password').
     *
     * @return string Nombre del atributo de la contraseña.
     */
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    /**
     * Define un descriptor de acceso (Accessor) y mutador (Mutator) para el atributo 'name'.
     *
     * Facilita la compatibilidad con Laravel Breeze permitiendo interactuar con el atributo 'name'
     * mientras que en la base de datos se lee y escribe sobre la columna real 'nombre'.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute Descriptor de atributo para 'name'.
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
     * Define un mutador (Mutator) para el atributo 'password'.
     *
     * Mapea el valor asignado a 'password' directamente a la columna real 'password_hash'
     * para asegurar la compatibilidad con los sistemas nativos de autenticación de Laravel.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute Descriptor de atributo para 'password'.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => [
                'password_hash' => $value,
            ],
        );
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre el usuario y sus eventos.
     *
     * Establece que un usuario puede tener uno o más eventos creados asociados a través
     * de la clave foránea 'usuario_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto de la relación de eventos.
     */
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'usuario_id');
    }

    /**
     * Define la relación "uno a muchos" (HasMany) entre el usuario y sus listas de regalos.
     *
     * Establece que un usuario puede tener múltiples listas de regalos creadas bajo su
     * autoría asociadas mediante la clave foránea 'user_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto de la relación de listas de regalos.
     */
    public function listasRegalos()
    {
        return $this->hasMany(ListaRegalo::class, 'user_id');
    }
}
