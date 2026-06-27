<?php

namespace App\Observers;

use App\Models\Evidencia;
use App\Models\LogActividad;

class EvidenciaObserver
{
    public function created(Evidencia $evidencia): void
    {
        LogActividad::create([
            'evidencia_id' => $evidencia->id,
            'user_id'      => auth()->id(),
            'accion'       => 'extraccion',
            'descripcion'  => "Novedad N° {$evidencia->nro_novedad} registrada. Motivo: {$evidencia->motivo} {$evidencia->motivo_nro}.",
            'ip_origen'    => request()->ip(),
            'created_at'   => now(),
        ]);
    }

    public function updated(Evidencia $evidencia): void
    {
        if ($evidencia->wasChanged('estado') && $evidencia->estado === 'entregado') {
            LogActividad::create([
                'evidencia_id' => $evidencia->id,
                'user_id'      => auth()->id(),
                'accion'       => 'entrega',
                'descripcion'  => "Oficio {$evidencia->oficio_entrega} — Entregado a {$evidencia->apellidos_receptor} {$evidencia->nombres_receptor} ({$evidencia->cargo_receptor}).",
                'ip_origen'    => request()->ip(),
                'created_at'   => now(),
            ]);
        }
    }
}
