@extends('layouts.app')

@section('title', 'Constancias de Monitoreo')
@section('page-title', 'CONSTANCIAS DE MONITOREO — CÁMARAS DE SEGURIDAD')

@section('content')
@php $user = auth()->user(); @endphp

{{-- Identificación del Funcionario --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3">
        <div class="row align-items-center g-2">
            <div class="col-auto">
                <span class="badge" style="background:var(--sicea-verde);font-size:.68rem;letter-spacing:.3px">
                    <i class="fas fa-id-badge me-1"></i>IDENTIFICACIÓN DEL FUNCIONARIO
                </span>
            </div>
            <div class="col-auto">
                <span class="fw-semibold" style="font-size:.82rem;color:var(--sicea-verde-dark)">Cód.:</span>
                <span style="font-size:.82rem">{{ $user->cod_funcionario }}</span>
            </div>
            <div class="col-auto">
                <span class="fw-semibold" style="font-size:.82rem;color:var(--sicea-verde-dark)">Grado:</span>
                <span style="font-size:.82rem">{{ $user->grado }}</span>
            </div>
            <div class="col-auto">
                <span class="fw-semibold" style="font-size:.82rem;color:var(--sicea-verde-dark)">Nombre:</span>
                <span style="font-size:.82rem">{{ $user->nombre_display }}</span>
            </div>
            <div class="col">
                <span class="fw-semibold" style="font-size:.82rem;color:var(--sicea-verde-dark)">Unidad:</span>
                <span style="font-size:.82rem">{{ $user->unidad }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Barra de filtros + acción --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3">
        <form method="GET" action="{{ route('constancias.index') }}" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600;color:var(--sicea-gris-texto)">Desde</label>
                <input type="date" name="fecha_desde" class="form-control form-control-sm"
                       value="{{ request('fecha_desde') }}" style="font-size:.82rem">
            </div>
            <div class="col-auto">
                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600;color:var(--sicea-gris-texto)">Hasta</label>
                <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                       value="{{ request('fecha_hasta') }}" style="font-size:.82rem">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-secondary" style="font-size:.8rem">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                @if(request('fecha_desde') || request('fecha_hasta'))
                <a href="{{ route('constancias.index') }}" class="btn btn-sm btn-link text-muted" style="font-size:.8rem">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabla de constancias --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background:var(--sicea-verde)">
        <h6 class="mb-0 text-white fw-semibold" style="font-size:.82rem;letter-spacing:.4px">
            <i class="fas fa-list me-2"></i>LIBRO DIGITAL DE CONSTANCIAS DE MONITOREO
        </h6>
        <button type="button" class="btn btn-primary btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalConstancia" style="font-size:.82rem">
            <i class="fas fa-plus-circle me-1"></i>Ingresar Constancia
        </button>
    </div>
    <div class="card-body p-0">
        @if($constancias->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fas fa-book-open fa-2x mb-2 d-block" style="opacity:.3"></i>
            <span style="font-size:.85rem">No hay constancias registradas
                @if(request('fecha_desde') || request('fecha_hasta'))
                en el período seleccionado
                @endif
            </span>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" style="font-size:.78rem">
                <thead style="background:var(--sicea-fondo)">
                    <tr>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">N°</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">FECHA/HORA</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">CÓD. FUNC.</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">GRADO</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">APELLIDOS Y NOMBRE</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">CONSTANCIA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($constancias as $c)
                    <tr>
                        <td class="px-3 py-2 fw-bold text-center" style="color:var(--sicea-verde-dark)">
                            {{ str_pad($c->nro_orden, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-3 py-2 text-nowrap">
                            {{ $c->created_at->format('d/m/Y') }}<br>
                            <span class="text-muted">{{ $c->created_at->format('H:i') }} hrs.</span>
                        </td>
                        <td class="px-3 py-2 fw-semibold">{{ $c->cod_funcionario }}</td>
                        <td class="px-3 py-2 text-nowrap">{{ $c->grado }}</td>
                        <td class="px-3 py-2">{{ $c->apellidos_nombre }}</td>
                        <td class="px-3 py-2" style="max-width:380px">{{ $c->descripcion }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center py-2 px-3" style="background:var(--sicea-fondo)">
        <span style="font-size:.75rem;color:var(--sicea-gris-mid)">
            Mostrando {{ $constancias->firstItem() ?? 0 }}–{{ $constancias->lastItem() ?? 0 }}
            de {{ $constancias->total() }} registros
        </span>
        {{ $constancias->links('pagination::bootstrap-5') }}
    </div>
</div>

@if($user->rol === 'sip')
{{-- Tabla de novedades de extracción (evidencias) — solo Personal SIP --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background:var(--sicea-verde-dark)">
        <h6 class="mb-0 text-white fw-semibold" style="font-size:.82rem;letter-spacing:.4px">
            <i class="fas fa-film me-2"></i>NOVEDADES DE EXTRACCIÓN DE IMÁGENES — FISCALÍA / TRIBUNAL
        </h6>
        <button type="button" class="btn btn-sm fw-semibold"
                style="background:var(--sicea-lima);color:var(--sicea-verde-dark);font-size:.78rem"
                data-bs-toggle="modal" data-bs-target="#modalNovedad">
            <i class="fas fa-plus-circle me-1"></i>Ingresar Novedad
        </button>
    </div>
    <div class="card-body p-0">
        @if($evidencias->isEmpty())
        <div class="text-center py-4 text-muted">
            <i class="fas fa-folder-open fa-2x mb-2 d-block" style="opacity:.3"></i>
            <span style="font-size:.85rem">No hay novedades de extracción registradas
                @if(request('fecha_desde') || request('fecha_hasta'))
                en el período seleccionado
                @endif
            </span>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" style="font-size:.78rem">
                <thead style="background:var(--sicea-fondo)">
                    <tr>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">N°</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">FECHA/HORA</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">CÓD. FUNC.</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">ESTAMENTO SOLICITANTE</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark);white-space:nowrap">MOTIVO / N°</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">TIPO GRABACIÓN</th>
                        <th class="px-3 py-2 fw-semibold text-center" style="color:var(--sicea-verde-dark);white-space:nowrap">ESTADO</th>
                        <th class="px-3 py-2 fw-semibold text-center" style="color:var(--sicea-verde-dark);white-space:nowrap">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($evidencias as $e)
                    <tr>
                        <td class="px-3 py-2 fw-bold text-center" style="color:var(--sicea-verde-dark)">
                            {{ str_pad($e->nro_novedad, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-3 py-2 text-nowrap">
                            {{ \Carbon\Carbon::parse($e->fecha_novedad)->format('d/m/Y') }}<br>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($e->fecha_novedad)->format('H:i') }} hrs.</span>
                        </td>
                        <td class="px-3 py-2 fw-semibold text-nowrap">{{ $e->cod_funcionario }}</td>
                        <td class="px-3 py-2">{{ $e->estamento_solicitante }}</td>
                        <td class="px-3 py-2 text-nowrap">
                            <span class="fw-semibold">{{ $e->motivo }}</span><br>
                            <span class="text-muted">{{ $e->motivo_nro }}</span>
                        </td>
                        <td class="px-3 py-2">{{ $e->tipo_grabacion ?? '—' }}</td>
                        <td class="px-3 py-2 text-center">
                            @if($e->estado === 'entregado')
                                <span class="badge" style="background:var(--sicea-verde);font-size:.65rem">ENTREGADO</span>
                            @else
                                <span class="badge bg-warning text-dark" style="font-size:.65rem">PENDIENTE</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-center">
                            <a href="{{ route('evidencias.show', $e) }}"
                               class="btn btn-sm fw-semibold"
                               style="background:var(--sicea-verde-dark);color:#fff;font-size:.72rem">
                                <i class="fas fa-eye me-1"></i>Gestionar
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center py-2 px-3" style="background:var(--sicea-fondo)">
        <span style="font-size:.75rem;color:var(--sicea-gris-mid)">
            Mostrando {{ $evidencias->firstItem() ?? 0 }}–{{ $evidencias->lastItem() ?? 0 }}
            de {{ $evidencias->total() }} registros
        </span>
        {{ $evidencias->links('pagination::bootstrap-5') }}
    </div>
</div>
@endif

{{-- Modal: Ingresar Constancia --}}
<div class="modal fade" id="modalConstancia" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header py-2" style="background:var(--sicea-verde)">
                <h5 class="modal-title text-white fw-semibold" id="tituloModal" style="font-size:.9rem;letter-spacing:.4px">
                    <i class="fas fa-book-open me-2"></i>INGRESO DE CONSTANCIA DE MONITOREO
                </h5>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('constancias.store') }}">
                @csrf
                <div class="modal-body">

                    {{-- Sección 1: Identificación automática --}}
                    <div class="p-2 mb-3 rounded" style="background:var(--sicea-fondo);border:1px solid var(--sicea-gris-light)">
                        <p class="mb-2 fw-bold" style="font-size:.72rem;color:var(--sicea-verde-dark);letter-spacing:.5px;text-transform:uppercase">
                            <i class="fas fa-robot me-1"></i>Datos asignados automáticamente por el servidor
                        </p>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">N° Constancia</label>
                                <input type="text" class="form-control form-control-sm" value="{{ str_pad($nroSiguiente, 3, '0', STR_PAD_LEFT) }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Fecha / Hora</label>
                                <input type="text" class="form-control form-control-sm" value="Se asignará al guardar" disabled style="font-size:.78rem;background:#e9ecef;color:var(--sicea-gris-mid)">
                            </div>
                        </div>
                    </div>

                    {{-- Sección 2: Identificación del Funcionario --}}
                    <div class="p-2 mb-3 rounded" style="background:var(--sicea-fondo);border:1px solid var(--sicea-gris-light)">
                        <p class="mb-2 fw-bold" style="font-size:.72rem;color:var(--sicea-verde-dark);letter-spacing:.5px;text-transform:uppercase">
                            <i class="fas fa-id-badge me-1"></i>Identificación del Funcionario
                        </p>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Cód. Funcionario</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->cod_funcionario }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Grado</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->grado }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Apellidos y Nombre</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->nombre_display }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-12">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Unidad</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->unidad }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                        </div>
                    </div>

                    {{-- Sección 3: Constancia --}}
                    <div>
                        <label for="descripcion" class="form-label fw-semibold" style="font-size:.82rem;color:var(--sicea-gris-texto)">
                            Constancia <span class="text-danger">*</span>
                        </label>
                        <textarea id="descripcion"
                                  name="descripcion"
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  rows="4"
                                  maxlength="500"
                                  placeholder="Ej: DESDE LAS 20:50 HORAS SISTEMA CCTV SIN VISUALIZACIÓN EN MONITOR N°2"
                                  style="font-size:.85rem;text-transform:uppercase;resize:vertical"
                                  oninput="this.value=this.value.toUpperCase(); actualizarContador(this)">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback" style="font-size:.78rem">{{ $message }}</div>
                        @enderror
                        <div class="d-flex justify-content-between mt-1">
                            <span style="font-size:.7rem;color:var(--sicea-gris-mid)">El registro será inmutable una vez guardado.</span>
                            <span id="charCount" style="font-size:.7rem;color:var(--sicea-gris-mid)">0 / 500</span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fw-semibold">
                        <i class="fas fa-save me-1"></i>Guardar Constancia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@if($user->rol === 'sip')
{{-- Modal: Ingresar Novedad de Extracción — solo Personal SIP --}}
<div class="modal fade" id="modalNovedad" tabindex="-1" aria-labelledby="tituloModalNovedad" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header py-2" style="background:var(--sicea-verde-dark)">
                <h5 class="modal-title text-white fw-semibold" id="tituloModalNovedad" style="font-size:.9rem;letter-spacing:.4px">
                    <i class="fas fa-film me-2"></i>INGRESO DE NOVEDAD — EXTRACCIÓN DE IMÁGENES
                </h5>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('evidencias.store') }}">
                @csrf
                <div class="modal-body">

                    {{-- Sección 1: Datos automáticos --}}
                    <div class="p-2 mb-3 rounded" style="background:var(--sicea-fondo);border:1px solid var(--sicea-gris-light)">
                        <p class="mb-2 fw-bold" style="font-size:.72rem;color:var(--sicea-verde-dark);letter-spacing:.5px;text-transform:uppercase">
                            <i class="fas fa-robot me-1"></i>Datos asignados automáticamente por el servidor
                        </p>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">N° Novedad</label>
                                <input type="text" class="form-control form-control-sm" value="{{ str_pad($nroSiguiente, 3, '0', STR_PAD_LEFT) }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Fecha / Hora</label>
                                <input type="text" class="form-control form-control-sm" value="Se asignará al guardar" disabled style="font-size:.78rem;background:#e9ecef;color:var(--sicea-gris-mid)">
                            </div>
                        </div>
                    </div>

                    {{-- Sección 2: Identificación del Funcionario --}}
                    <div class="p-2 mb-3 rounded" style="background:var(--sicea-fondo);border:1px solid var(--sicea-gris-light)">
                        <p class="mb-2 fw-bold" style="font-size:.72rem;color:var(--sicea-verde-dark);letter-spacing:.5px;text-transform:uppercase">
                            <i class="fas fa-id-badge me-1"></i>Identificación del Funcionario
                        </p>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600">Cód. Funcionario</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->cod_funcionario }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600">Grado</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->grado }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600">Apellidos y Nombre</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->nombre_display }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                            <div class="col-12">
                                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600">Unidad</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $user->unidad }}" disabled style="font-size:.82rem;background:#e9ecef">
                            </div>
                        </div>
                    </div>

                    {{-- Sección 3: Estamento Solicitante --}}
                    <div class="p-2 mb-3 rounded" style="border:1px solid var(--sicea-gris-light)">
                        <p class="mb-2 fw-bold" style="font-size:.72rem;color:var(--sicea-verde-dark);letter-spacing:.5px;text-transform:uppercase">
                            <i class="fas fa-building me-1"></i>Estamento Solicitante
                        </p>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600">Institución Solicitante <span class="text-danger">*</span></label>
                                <input type="text" name="estamento_solicitante"
                                       class="form-control form-control-sm @error('estamento_solicitante') is-invalid @enderror"
                                       value="{{ old('estamento_solicitante') }}"
                                       placeholder="Ej: Fiscalía Regional Metropolitana Centro Norte"
                                       style="font-size:.82rem;text-transform:uppercase"
                                       oninput="this.value=this.value.toUpperCase()">
                                @error('estamento_solicitante')<div class="invalid-feedback" style="font-size:.75rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600">Motivo <span class="text-danger">*</span></label>
                                <select name="motivo" class="form-select form-select-sm @error('motivo') is-invalid @enderror" style="font-size:.82rem">
                                    <option value="">— Seleccione —</option>
                                    @foreach(['CAUSA','RIT','RUC','DOCUMENTACIÓN ELECTRÓNICA'] as $m)
                                    <option value="{{ $m }}" {{ old('motivo') === $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                                @error('motivo')<div class="invalid-feedback" style="font-size:.75rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600">N° Motivo <span class="text-danger">*</span></label>
                                <input type="text" name="motivo_nro"
                                       class="form-control form-control-sm @error('motivo_nro') is-invalid @enderror"
                                       value="{{ old('motivo_nro') }}"
                                       placeholder="Ej: 2400123456-K"
                                       style="font-size:.82rem;text-transform:uppercase"
                                       oninput="this.value=this.value.toUpperCase()">
                                @error('motivo_nro')<div class="invalid-feedback" style="font-size:.75rem">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección 4: Grabación Solicitada --}}
                    <div class="p-2 mb-2 rounded" style="border:1px solid var(--sicea-gris-light)">
                        <p class="mb-2 fw-bold" style="font-size:.72rem;color:var(--sicea-verde-dark);letter-spacing:.5px;text-transform:uppercase">
                            <i class="fas fa-video me-1"></i>Identificación de Grabación Solicitada
                        </p>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600">Desde (fecha/hora) <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="grabacion_desde"
                                       class="form-control form-control-sm @error('grabacion_desde') is-invalid @enderror"
                                       value="{{ old('grabacion_desde') }}"
                                       style="font-size:.82rem">
                                @error('grabacion_desde')<div class="invalid-feedback" style="font-size:.75rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600">Hasta (fecha/hora) <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="grabacion_hasta"
                                       class="form-control form-control-sm @error('grabacion_hasta') is-invalid @enderror"
                                       value="{{ old('grabacion_hasta') }}"
                                       style="font-size:.82rem">
                                @error('grabacion_hasta')<div class="invalid-feedback" style="font-size:.75rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600">Tipo Grabación <span class="text-danger">*</span></label>
                                <select name="tipo_grabacion" class="form-select form-select-sm @error('tipo_grabacion') is-invalid @enderror" style="font-size:.82rem">
                                    <option value="">— Seleccione —</option>
                                    @foreach(['CCTV UNIDAD','CCTV VEHÍCULO POLICIAL','VIDEOCÁMARA CORPORAL'] as $t)
                                    <option value="{{ $t }}" {{ old('tipo_grabacion') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                                @error('tipo_grabacion')<div class="invalid-feedback" style="font-size:.75rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1" style="font-size:.75rem;font-weight:600">Equipo / Vehículo <span class="text-danger">*</span></label>
                                <input type="text" name="identificador_grabacion"
                                       class="form-control form-control-sm @error('identificador_grabacion') is-invalid @enderror"
                                       value="{{ old('identificador_grabacion') }}"
                                       placeholder="Ej: GRABADOR 3RA. COMISARÍA"
                                       style="font-size:.82rem;text-transform:uppercase"
                                       oninput="this.value=this.value.toUpperCase()">
                                @error('identificador_grabacion')<div class="invalid-feedback" style="font-size:.75rem">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-sm btn-primary fw-semibold">
                        <i class="fas fa-save me-1"></i>Guardar Novedad
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function actualizarContador(textarea) {
    document.getElementById('charCount').textContent = textarea.value.length + ' / 500';
}

// Reabrir modal si hay errores de validación
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        @if(old('descripcion') !== null && !old('estamento_solicitante'))
        new bootstrap.Modal(document.getElementById('modalConstancia')).show();
        actualizarContador(document.getElementById('descripcion'));
        @elseif(old('estamento_solicitante') !== null)
        new bootstrap.Modal(document.getElementById('modalNovedad')).show();
        @endif
    });
@endif
</script>
@endpush
