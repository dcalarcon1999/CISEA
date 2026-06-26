<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constancia extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nro_orden',
        'cod_funcionario',
        'grado',
        'apellidos_nombre',
        'unidad',
        'descripcion',
        'operador_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }
}
