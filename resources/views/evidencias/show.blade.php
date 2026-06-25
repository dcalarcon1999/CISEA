@extends('layouts.app')

@section('title', 'Detalle Novedad N° ' . $evidencia->nro_novedad)
@section('page-title', 'Detalle Novedad N° ' . $evidencia->nro_novedad)

@section('content')
<div class="row justify-content-center">
<div class="col-xl-9 col-lg-11">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('evidencias.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Bandeja Principal
        </a>
        @if($evidencia->estaEntregada())
            <span class="badge bg-success px-3 py-2" style="font-size:.82rem">
                <i class="fas fa-check-circle me-1"></i> Registro Cerrado — Entregado
            </span>
        @else
            <span class="badge bg-warning text-dark px-3 py-2" style="font-size:.82rem">
                <i class="fas fa-clock me-1"></i> Pendiente de Entrega
            </span>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show py-2">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Sección 1 --}}
    <div class="form-section mb-3">
        <div class="section-header">1. IDENTIFICACIÓN NOVEDAD</div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="funcionario-label">Nro. Novedad</div>
                    <div class="funcionario-value fw-bold fs-5">{{ $evidencia->nro_novedad }}</div>
                </div>
                <div class="col-md-9">
                    <div class="funcionario-label">Fecha y Hora de Registro</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->fecha_novedad->format('d/m/Y H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 2 --}}
    <div class="form-section mb-3">
        <div class="section-header">2. IDENTIFICACIÓN FUNCIONARIO</div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="funcionario-label">Cod. Funcionario</div>
                    <div class="funcionario-value">{{ $evidencia->cod_funcionario }}</div>
                </div>
                <div class="col-md-2">
                    <div class="funcionario-label">Grado</div>
                    <div class="funcionario-value">{{ $evidencia->grado }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Apellidos y Nombre</div>
                    <div class="funcionario-value fw-bold">
                        {{ $evidencia->operador?->nombre_display ?? $evidencia->apellidos_nombre }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="funcionario-label">Unidad</div>
                    <div class="funcionario-value">{{ $evidencia->unidad }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 3 --}}
    <div class="form-section mb-3">
        <div class="section-header">3. IDENTIFICACIÓN ESTAMENTO SOLICITANTE</div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-12">
                    <div class="funcionario-label">Estamento Solicitante</div>
                    <div class="funcionario-value">{{ $evidencia->estamento_solicitante }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Motivo</div>
                    @php
                        $color = match($evidencia->motivo) {
                            'RUC'                      => 'bg-info text-dark',
                            'RIT'                      => 'bg-secondary',
                            'CAUSA'                    => 'bg-warning text-dark',
                            'DOCUMENTACIÓN ELECTRÓNICA'=> 'bg-primary',
                            default                    => 'bg-light text-dark',
                        };
                    @endphp
                    <span class="badge {{ $color }} px-3 py-2">{{ $evidencia->motivo }}</span>
                </div>
                <div class="col-md-8">
                    <div class="funcionario-label">Motivo Nro.</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->motivo_nro }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 4 --}}
    <div class="form-section mb-3">
        <div class="section-header">4. IDENTIFICACIÓN DE GRABACIONES SOLICITADAS</div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="funcionario-label">Desde</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->grabacion_desde?->format('H:i d/m/Y') ?? '—' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Hasta</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->grabacion_hasta?->format('H:i d/m/Y') ?? '—' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Duración</div>
                    @if($evidencia->grabacion_desde && $evidencia->grabacion_hasta)
                    @php
                        $totalMin = $evidencia->grabacion_desde->diffInMinutes($evidencia->grabacion_hasta);
                        $dias     = intdiv($totalMin, 1440);
                        $horas    = intdiv($totalMin % 1440, 60);
                        $mins     = $totalMin % 60;
                        $partes   = [];
                        if ($dias > 0)  $partes[] = "$dias DÍA"    . ($dias  !== 1 ? 'S' : '');
                        if ($horas > 0) $partes[] = "$horas HORA"  . ($horas !== 1 ? 'S' : '');
                        $partes[] = "$mins MINUTO" . ($mins !== 1 ? 'S' : '');
                        $ultimo   = array_pop($partes);
                        $duracion = $partes ? implode(', ', $partes) . ' Y ' . $ultimo : $ultimo;
                    @endphp
                    <div class="funcionario-value text-success fw-bold">{{ $duracion }}</div>
                    @else
                    <div class="funcionario-value text-muted">—</div>
                    @endif
                </div>
                <div class="col-md-5">
                    <div class="funcionario-label">Tipo de grabación</div>
                    <div class="funcionario-value">{{ $evidencia->tipo_grabacion ?? '—' }}</div>
                </div>
                <div class="col-md-7">
                    <div class="funcionario-label">Equipo Grabador / Vehículo</div>
                    <div class="funcionario-value">{{ $evidencia->identificador_grabacion ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 5 --}}
    <div class="form-section mb-4">
        <div class="section-header">5. IDENTIFICACIÓN OFICIO DE ENTREGA</div>
        <div class="section-body">
            @if($evidencia->estaEntregada())
            <div class="row g-3">
                <div class="col-md-5">
                    <div class="funcionario-label">Oficio de Entrega</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->oficio_entrega }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Fecha Oficio</div>
                    <div class="funcionario-value">{{ \Carbon\Carbon::parse($evidencia->fecha_oficio)->format('d/m/Y') }}</div>
                </div>
                <div class="col-md-3">
                    <div class="funcionario-label">RUN Receptor</div>
                    <div class="funcionario-value">{{ $evidencia->run_receptor }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Apellidos Receptor</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->apellidos_receptor }}</div>
                </div>
                <div class="col-md-3">
                    <div class="funcionario-label">Nombres Receptor</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->nombres_receptor }}</div>
                </div>
                <div class="col-md-2">
                    <div class="funcionario-label">Cargo</div>
                    <div class="funcionario-value">{{ $evidencia->cargo_receptor }}</div>
                </div>
            </div>
            @else
            <div class="text-center py-3 text-muted">
                <i class="fas fa-clock fa-2x mb-2 d-block text-warning"></i>
                <p class="mb-2">Pendiente de completar tras la extracción de imágenes.</p>
                <a href="{{ route('evidencias.edit', $evidencia) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-pencil-alt me-1"></i> Completar Oficio de Entrega
                </a>
            </div>
            @endif
        </div>
    </div>

</div>
</div>
@endsection
