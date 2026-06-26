@extends('layouts.app')

@section('title', 'Logs de Auditoría')
@section('page-title', 'AUDITORÍA DEL SISTEMA — LOGS INMUTABLES')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color:var(--sicea-verde); color:white;">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-shield-alt me-2"></i>
                    Historial Inmutable de Logs de Actividad
                </h6>
            </div>
            <div class="card-body text-center py-5">
                <i class="fas fa-tools fa-3x mb-3" style="color:var(--sicea-verde); opacity:.5"></i>
                <h5 class="fw-semibold" style="color:var(--sicea-verde-dark)">Módulo en implementación</h5>
                <p class="text-muted mb-1" style="font-size:.9rem">
                    Los logs de auditoría y la gestión de usuarios estarán disponibles en el <strong>Sprint 5</strong>.
                </p>
                <p class="text-muted" style="font-size:.82rem">
                    Este módulo incluirá:<br>
                    Historial completo de acciones (visualización, extracción, entrega), gestión de usuarios
                    y administración de roles. La tabla <code>logs_actividad</code> no admite UPDATE ni DELETE.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
