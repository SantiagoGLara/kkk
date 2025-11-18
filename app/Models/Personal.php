<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personal extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'id_personal';

    protected $fillable = [
        'user_id',
        'nombre',
        'tipo_personal',
        'nivel_academico',
        'antiguedad',
        'estado',
        'forma_pago',
        'jornada_laboral',
        'fecha_ingreso',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'antiguedad' => 'integer',
    ];

    /**
     * Relación con User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con TipoPersonal
     */
    public function tipoPersonal(): BelongsTo
    {
        return $this->belongsTo(TipoPersonal::class, 'tipo_personal', 'id_tipo_personal');
    }

    /**
     * Scope para obtener solo personal activo
     */
    public function scopeActivo($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para filtrar por tipo de personal
     */
    public function scopePorTipo($query, $tipoId)
    {
        return $query->where('tipo_personal', $tipoId);
    }
}
