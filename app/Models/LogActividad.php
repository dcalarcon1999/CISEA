<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Immutable audit log — no update or delete operations exist for this model.
 * Every action on Evidencia dispatches an observer that calls LogActividad::create().
 */
class LogActividad extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'evidencia_id',
        'user_id',
        'accion',       // 'visualizacion' | 'extraccion' | 'entrega'
        'descripcion',
        'ip_origen',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function evidencia()
    {
        return $this->belongsTo(Evidencia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
