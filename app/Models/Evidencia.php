<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        // Sección 1
        'nro_novedad',
        'fecha_novedad',
        // Sección 2
        'cod_funcionario',
        'grado',
        'apellidos_nombre',
        'unidad',
        // Sección 3
        'estamento_solicitante',
        'motivo',
        'motivo_nro',
        // Sección 4
        'grabacion_desde',
        'grabacion_hasta',
        'tipo_grabacion',
        'identificador_grabacion',
        // Sección 5
        'oficio_entrega',
        'fecha_oficio',
        'run_receptor',
        'apellidos_receptor',
        'nombres_receptor',
        'cargo_receptor',
        // Meta
        'estado',
        'operador_id',
    ];

    protected $casts = [
        'fecha_novedad'    => 'datetime',
        'grabacion_desde'  => 'datetime',
        'grabacion_hasta'  => 'datetime',
        'fecha_oficio'     => 'date',
    ];

    public function estaEntregada(): bool
    {
        return $this->estado === 'entregado';
    }

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    public function logs()
    {
        return $this->hasMany(LogActividad::class);
    }
}
