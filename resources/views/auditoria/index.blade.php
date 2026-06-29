@extends('layouts.app')

@section('title', 'Logs de Auditoría')
@section('page-title', 'AUDITORÍA DEL SISTEMA — LOGS INMUTABLES')

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="alert mb-0 py-2 px-3 d-flex align-items-center gap-2"
             style="background-color:#fff3cd; border:1px solid #ffc107; border-radius:6px; font-size:.82rem;">
            <i class="fas fa-lock" style="color:#856404;"></i>
            <span style="color:#856404;">
                <strong>Registro inmutable.</strong>
                Esta tabla es <em>append-only</em> — ningún usuario ni proceso puede modificar o eliminar entradas.
                Dos triggers MySQL garantizan esta restricción a nivel de motor de base de datos.
            </span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center"
         style="background-color:var(--sicea-verde); color:white;">
        <h6 class="mb-0 fw-semibold">
            <i class="fas fa-shield-alt me-2"></i>
            Historial de Actividad — {{ $logs->total() }} registros
        </h6>
        <span class="badge" style="background-color:var(--sicea-lima); color:var(--sicea-verde-dark); font-size:.7rem;">
            Solo lectura
        </span>
    </div>

    <div class="card-body p-0">
        @if($logs->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fas fa-database fa-2x mb-2 d-block" style="opacity:.3"></i>
                No hay registros de actividad aún.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0" style="font-size:.83rem;">
                <thead style="background-color:#f8f9fa;">
                    <tr>
                        <th class="px-3 py-2">#</th>
                        <th class="px-3 py-2">Fecha y Hora</th>
                        <th class="px-3 py-2">Acción</th>
                        <th class="px-3 py-2">Funcionario</th>
                        <th class="px-3 py-2">Evidencia N°</th>
                        <th class="px-3 py-2">Descripción</th>
                        <th class="px-3 py-2">IP Origen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td class="px-3 py-2 text-muted">{{ $log->id }}</td>
                        <td class="px-3 py-2 text-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="px-3 py-2">
                            @php
                                $badge = match($log->accion) {
                                    'visualizacion' => ['bg-info',    'fa-eye',          'Visualización'],
                                    'extraccion'    => ['bg-warning text-dark', 'fa-download',   'Extracción'],
                                    'entrega'       => ['bg-success', 'fa-paper-plane',  'Entrega'],
                                    default         => ['bg-secondary','fa-circle',      $log->accion],
                                };
                            @endphp
                            <span class="badge {{ $badge[0] }}" style="font-size:.72rem;">
                                <i class="fas {{ $badge[1] }} me-1"></i>{{ $badge[2] }}
                            </span>
                        </td>
                        <td class="px-3 py-2">
                            @if($log->user)
                                <span class="fw-semibold" style="font-size:.8rem;">{{ $log->user->nombre_display }}</span><br>
                                <span class="text-muted" style="font-size:.72rem;">Cód. {{ $log->user->cod_funcionario }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if($log->evidencia)
                                <span class="fw-semibold"># {{ str_pad($log->evidencia->nro_novedad, 4, '0', STR_PAD_LEFT) }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="px-3 py-2" style="max-width:260px; white-space:normal;">
                            {{ $log->descripcion ?? '—' }}
                        </td>
                        <td class="px-3 py-2 text-muted font-monospace" style="font-size:.75rem;">
                            {{ $log->ip_origen ?? '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-3 py-2 border-top">
            {{ $logs->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
