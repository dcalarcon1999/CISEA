@extends('layouts.app')

@section('title', 'Panel de Evidencias')
@section('page-title', 'LIBRO DIGITAL DE REGISTRO DE NOVEDADES — IMÁGENES DE CÁMARAS DE SEGURIDAD')

@section('content')

{{-- Barra de acciones y filtros --}}
<div class="row mb-3 g-2 align-items-center">
    <div class="col-md-3">
        <a href="{{ route('evidencias.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Registrar Nueva Novedad
        </a>
    </div>
    <div class="col-md-5">
        <form method="GET" action="{{ route('evidencias.index') }}" class="d-flex gap-2">
            <input type="hidden" name="fecha_desde" value="{{ request('fecha_desde') }}">
            <input type="hidden" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
            <input type="text" name="buscar" class="form-control form-control-sm"
                placeholder="Buscar por Nro. Novedad, Funcionario o Motivo Nro."
                value="{{ request('buscar') }}">
            <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
        </form>
    </div>
    <div class="col-md-4">
        <form method="GET" action="{{ route('evidencias.index') }}" class="d-flex gap-1 align-items-center">
            <input type="hidden" name="buscar" value="{{ request('buscar') }}">
            <input class="form-control form-control-sm" type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
            <input class="form-control form-control-sm" type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
            <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
        </form>
    </div>
</div>

{{-- Tabla de novedades --}}
<div class="table-responsive shadow-sm">
    <table class="table table-hover table-sm align-middle mb-0" id="tabla-evidencias">
        <thead class="table-dark">
            <tr>
                <th>Nro. Novedad</th>
                <th>Fecha</th>
                <th>Funcionario / Unidad</th>
                <th>Motivo</th>
                <th>Estamento Solicitante</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evidencias as $evidencia)
            <tr>
                <td><strong>{{ $evidencia->nro_novedad }}</strong></td>
                <td class="text-nowrap">{{ $evidencia->fecha_novedad->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="d-block fw-semibold" style="font-size:.85rem">
                        {{ $evidencia->operador?->nombre_display ?? $evidencia->apellidos_nombre }}
                    </span>
                    <span class="text-muted" style="font-size:.78rem">{{ $evidencia->grado }} — {{ $evidencia->unidad }}</span>
                </td>
                <td>
                    @php
                        $color = match($evidencia->motivo) {
                            'RUC'                      => 'bg-info text-dark',
                            'RIT'                      => 'bg-secondary',
                            'CAUSA'                    => 'bg-warning text-dark',
                            'DOCUMENTACIÓN ELECTRÓNICA'=> 'bg-primary',
                            default                    => 'bg-light text-dark',
                        };
                    @endphp
                    <span class="badge {{ $color }} me-1">{{ $evidencia->motivo }}</span>
                    <span style="font-size:.85rem">{{ $evidencia->motivo_nro }}</span>
                </td>
                <td style="font-size:.85rem">{{ $evidencia->estamento_solicitante }}</td>
                <td class="text-center">
                    @if($evidencia->estaEntregada())
                        <span class="badge bg-success">Entregado</span>
                    @else
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($evidencia->estaEntregada())
                        <a href="{{ route('evidencias.show', $evidencia) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> Ver Detalle
                        </a>
                    @else
                        <a href="{{ route('evidencias.edit', $evidencia) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-pencil-alt"></i> Completar Entrega
                        </a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                    No hay novedades registradas.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center mt-2">
    <p class="text-muted small mb-0">
        Mostrando {{ $evidencias->count() }} de {{ $evidencias->total() }} registros — SICEA
    </p>
    {{ $evidencias->withQueryString()->links('pagination::bootstrap-5') }}
</div>

@endsection
