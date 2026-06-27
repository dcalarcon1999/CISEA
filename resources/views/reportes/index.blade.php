@extends('layouts.app')

@section('title', 'Reportes y Fiscalización')
@section('page-title', 'REPORTES DE CONTROL Y TRAZABILIDAD')

@section('content')

{{-- KPIs --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:42px;height:42px;background:var(--sicea-verde);flex-shrink:0">
                        <i class="fas fa-film text-white" style="font-size:.95rem"></i>
                    </div>
                    <div>
                        <div style="font-size:1.6rem;font-weight:700;color:var(--sicea-verde-dark);line-height:1">
                            {{ $kpis['total_evidencias'] }}
                        </div>
                        <div style="font-size:.7rem;color:var(--sicea-gris-mid);text-transform:uppercase;letter-spacing:.3px">
                            Total Extracciones
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:42px;height:42px;background:#ffc107;flex-shrink:0">
                        <i class="fas fa-clock text-dark" style="font-size:.95rem"></i>
                    </div>
                    <div>
                        <div style="font-size:1.6rem;font-weight:700;color:#856404;line-height:1">
                            {{ $kpis['pendientes'] }}
                        </div>
                        <div style="font-size:.7rem;color:var(--sicea-gris-mid);text-transform:uppercase;letter-spacing:.3px">
                            Pendientes de Entrega
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:42px;height:42px;background:#198754;flex-shrink:0">
                        <i class="fas fa-check-circle text-white" style="font-size:.95rem"></i>
                    </div>
                    <div>
                        <div style="font-size:1.6rem;font-weight:700;color:#0a3622;line-height:1">
                            {{ $kpis['entregadas'] }}
                        </div>
                        <div style="font-size:.7rem;color:var(--sicea-gris-mid);text-transform:uppercase;letter-spacing:.3px">
                            Entregadas al MP
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width:42px;height:42px;background:var(--sicea-lima);flex-shrink:0">
                        <i class="fas fa-book-open" style="font-size:.95rem;color:var(--sicea-verde-dark)"></i>
                    </div>
                    <div>
                        <div style="font-size:1.6rem;font-weight:700;color:var(--sicea-verde-dark);line-height:1">
                            {{ $kpis['constancias_mes'] }}
                        </div>
                        <div style="font-size:.7rem;color:var(--sicea-gris-mid);text-transform:uppercase;letter-spacing:.3px">
                            Constancias este mes
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filtros --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2 px-3">
        <form method="GET" action="{{ route('reportes.index') }}" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Desde</label>
                <input type="date" name="fecha_desde" class="form-control form-control-sm"
                       value="{{ request('fecha_desde') }}" style="font-size:.82rem">
            </div>
            <div class="col-auto">
                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Hasta</label>
                <input type="date" name="fecha_hasta" class="form-control form-control-sm"
                       value="{{ request('fecha_hasta') }}" style="font-size:.82rem">
            </div>
            <div class="col-auto">
                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Estado</label>
                <select name="estado" class="form-select form-select-sm" style="font-size:.82rem">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="entregado" {{ request('estado') === 'entregado' ? 'selected' : '' }}>Entregado</option>
                </select>
            </div>
            <div class="col-auto">
                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Motivo</label>
                <select name="motivo" class="form-select form-select-sm" style="font-size:.82rem">
                    <option value="">Todos</option>
                    @foreach(['CAUSA','RIT','RUC','DOCUMENTACIÓN ELECTRÓNICA'] as $m)
                    <option value="{{ $m }}" {{ request('motivo') === $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label class="form-label mb-1" style="font-size:.72rem;font-weight:600;color:var(--sicea-gris-texto)">Buscar</label>
                <input type="text" name="buscar" class="form-control form-control-sm"
                       placeholder="Funcionario, Cód., Motivo N°, Estamento…"
                       value="{{ request('buscar') }}" style="font-size:.82rem">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-secondary" style="font-size:.8rem">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                @if(request()->hasAny(['fecha_desde','fecha_hasta','estado','motivo','buscar']))
                <a href="{{ route('reportes.index') }}" class="btn btn-sm btn-link text-muted" style="font-size:.8rem">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Tabla Evidencias --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header py-2" style="background:var(--sicea-verde-dark)">
        <h6 class="mb-0 text-white fw-semibold" style="font-size:.82rem;letter-spacing:.4px">
            <i class="fas fa-film me-2"></i>NOVEDADES DE EXTRACCIÓN DE IMÁGENES
        </h6>
    </div>
    <div class="card-body p-0">
        @if($evidencias->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fas fa-folder-open fa-2x mb-2 d-block" style="opacity:.3"></i>
            <span style="font-size:.85rem">No hay registros que coincidan con los filtros aplicados.</span>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" style="font-size:.78rem">
                <thead style="background:var(--sicea-fondo)">
                    <tr>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">N°</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">FECHA</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">FUNCIONARIO</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">ESTAMENTO SOLICITANTE</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">MOTIVO / N°</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">GRABACIÓN</th>
                        <th class="px-3 py-2 fw-semibold text-center" style="color:var(--sicea-verde-dark)">ESTADO</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">OFICIO</th>
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
                            <span class="text-muted">{{ \Carbon\Carbon::parse($e->fecha_novedad)->format('H:i') }}</span>
                        </td>
                        <td class="px-3 py-2">
                            <span class="d-block fw-semibold">{{ $e->apellidos_nombre }}</span>
                            <span class="text-muted">{{ $e->cod_funcionario }} — {{ $e->grado }}</span>
                        </td>
                        <td class="px-3 py-2" style="max-width:180px">{{ $e->estamento_solicitante }}</td>
                        <td class="px-3 py-2 text-nowrap">
                            <span class="fw-semibold">{{ $e->motivo }}</span><br>
                            <span class="text-muted">{{ $e->motivo_nro }}</span>
                        </td>
                        <td class="px-3 py-2 text-nowrap">
                            {{ $e->tipo_grabacion ?? '—' }}<br>
                            <span class="text-muted">{{ $e->identificador_grabacion ?? '' }}</span>
                        </td>
                        <td class="px-3 py-2 text-center">
                            @if($e->estado === 'entregado')
                                <span class="badge" style="background:var(--sicea-verde);font-size:.65rem">ENTREGADO</span>
                            @else
                                <span class="badge bg-warning text-dark" style="font-size:.65rem">PENDIENTE</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-nowrap">
                            @if($e->oficio_entrega)
                                <span class="fw-semibold">{{ $e->oficio_entrega }}</span><br>
                                <span class="text-muted">{{ \Carbon\Carbon::parse($e->fecha_oficio)->format('d/m/Y') }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
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

{{-- Tabla Constancias --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header py-2" style="background:var(--sicea-verde)">
        <h6 class="mb-0 text-white fw-semibold" style="font-size:.82rem;letter-spacing:.4px">
            <i class="fas fa-book-open me-2"></i>LIBRO DIGITAL DE CONSTANCIAS DE MONITOREO
        </h6>
    </div>
    <div class="card-body p-0">
        @if($constancias->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fas fa-book-open fa-2x mb-2 d-block" style="opacity:.3"></i>
            <span style="font-size:.85rem">No hay constancias que coincidan con los filtros aplicados.</span>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" style="font-size:.78rem">
                <thead style="background:var(--sicea-fondo)">
                    <tr>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">N°</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">FECHA/HORA</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">CÓD. FUNC.</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">GRADO</th>
                        <th class="px-3 py-2 fw-semibold" style="color:var(--sicea-verde-dark)">APELLIDOS Y NOMBRE</th>
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

@endsection
