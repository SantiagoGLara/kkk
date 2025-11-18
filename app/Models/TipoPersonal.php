<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPersonal extends Model
{
    protected $table = 'tipo_personal';
    protected $primaryKey = 'id_tipo_personal';

    protected $fillable = [
        'nombre_tipo',
        'caracteristicas_especiales',
    ];

    protected $casts = [
        'caracteristicas_especiales' => 'array',
    ];

    /**
     * Relación con Personal
     */
    public function personal(): HasMany
    {
        return $this->hasMany(Personal::class, 'tipo_personal', 'id_tipo_personal');
    }

    /**
     * Obtener solo personal activo de este tipo
     */
    public function personalActivo(): HasMany
    {
        return $this->personal()->where('estado', 'activo');
    }
}
