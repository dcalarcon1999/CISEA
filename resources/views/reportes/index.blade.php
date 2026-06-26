@extends('layouts.app')

@section('title', 'Reportes y Fiscalización')
@section('page-title', 'REPORTES DE CONTROL Y TRAZABILIDAD')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color:var(--sicea-verde); color:white;">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-chart-line me-2"></i>
                    Reportes de Control y Fiscalización
                </h6>
            </div>
            <div class="card-body text-center py-5">
                <i class="fas fa-tools fa-3x mb-3" style="color:var(--sicea-verde); opacity:.5"></i>
                <h5 class="fw-semibold" style="color:var(--sicea-verde-dark)">Módulo en implementación</h5>
                <p class="text-muted mb-1" style="font-size:.9rem">
                    Los reportes de control y trazabilidad estarán disponibles en el <strong>Sprint 4</strong>.
                </p>
                <p class="text-muted" style="font-size:.82rem">
                    Este módulo incluirá:<br>
                    Historial consolidado de extracciones y entregas con filtros por fecha, funcionario y estado.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
