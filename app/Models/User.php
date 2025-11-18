<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con Personal (1:1)
     */
    public function personal()
    {
        return $this->hasOne(Personal::class, 'user_id');
    }

    /**
     * Verificar si el usuario es RH Admin
     */
    public function isRhAdmin(): bool
    {
        return $this->role === 'rh_admin';
    }

    /**
     * Verificar si el usuario es empleado
     */
    public function isEmpleado(): bool
    {
        return $this->role === 'empleado';
    }

    /**
     * Obtener el tipo de personal (si es empleado)
     */
    public function getTipoPersonal()
    {
        return $this->personal?->tipoPersonal;
    }

    /**
     * Verificar si tiene un tipo de personal específico
     */
    public function hasTipoPersonal($tipoId): bool
    {
        return $this->personal && $this->personal->tipo_personal == $tipoId;
    }

    /**
     * Obtener las iniciales del nombre del usuario
     */
    public function initials(): string
    {
        $words = explode(' ', trim($this->name));

        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($this->name, 0, 2));
    }
}
