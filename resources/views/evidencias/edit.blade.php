@extends('layouts.app')

@section('title', 'Completar Oficio de Entrega')
@section('page-title', 'Completar Oficio de Entrega — Novedad N° {{ $evidencia->nro_novedad }}')

@section('content')
<div class="row justify-content-center">
<div class="col-xl-9 col-lg-11">

    <div class="mb-3">
        <a href="{{ route('evidencias.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Bandeja Principal
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger py-2">
        <ul class="mb-0 small">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('evidencias.update', $evidencia) }}" id="form-entrega">
    @csrf
    @method('PUT')

    {{-- Sección 1 — Solo lectura --}}
    <div class="form-section mb-3">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>1. IDENTIFICACIÓN NOVEDAD</span>
            <span class="badge bg-secondary fw-normal" style="font-size:.7rem;letter-spacing:0"><i class="fas fa-lock me-1"></i>Solo lectura</span>
        </div>
        <div class="section-body">
            <div class="funcionario-card d-flex align-items-center gap-4 p-3 rounded">
                <i class="fas fa-hashtag fa-2x text-secondary"></i>
                <div class="row g-2 flex-grow-1">
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
    </div>

    {{-- Sección 2 — Solo lectura --}}
    <div class="form-section mb-3">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>2. IDENTIFICACIÓN FUNCIONARIO</span>
            <span class="badge bg-secondary fw-normal" style="font-size:.7rem;letter-spacing:0"><i class="fas fa-lock me-1"></i>Solo lectura</span>
        </div>
        <div class="section-body">
            <div class="funcionario-card d-flex align-items-center gap-3 p-3 rounded">
                <i class="fas fa-id-badge fa-2x text-secondary"></i>
                <div class="row g-2 flex-grow-1">
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
                        <div class="funcionario-value fw-bold">{{ $evidencia->operador?->nombre_display ?? $evidencia->apellidos_nombre }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="funcionario-label">Unidad</div>
                        <div class="funcionario-value">{{ $evidencia->unidad }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 3 — Solo lectura --}}
    <div class="form-section mb-3">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>3. IDENTIFICACIÓN ESTAMENTO SOLICITANTE</span>
            <span class="badge bg-secondary fw-normal" style="font-size:.7rem;letter-spacing:0"><i class="fas fa-lock me-1"></i>Solo lectura</span>
        </div>
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
                    <span class="badge {{ $color }}">{{ $evidencia->motivo }}</span>
                </div>
                <div class="col-md-8">
                    <div class="funcionario-label">Motivo Nro.</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->motivo_nro }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 4 — Solo lectura --}}
    <div class="form-section mb-3">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>4. IDENTIFICACIÓN DE GRABACIONES SOLICITADAS</span>
            <span class="badge bg-secondary fw-normal" style="font-size:.7rem;letter-spacing:0"><i class="fas fa-lock me-1"></i>Solo lectura</span>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="funcionario-label">Desde</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->grabacion_desde->format('H:i d/m/Y') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Hasta</div>
                    <div class="funcionario-value fw-bold">{{ $evidencia->grabacion_hasta->format('H:i d/m/Y') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="funcionario-label">Duración</div>
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
                </div>
                <div class="col-md-5">
                    <div class="funcionario-label">Tipo de grabación</div>
                    <div class="funcionario-value">{{ $evidencia->tipo_grabacion }}</div>
                </div>
                <div class="col-md-7">
                    <div class="funcionario-label">Equipo Grabador / Vehículo</div>
                    <div class="funcionario-value">{{ $evidencia->identificador_grabacion }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sección 5 — EDITABLE --}}
    <div class="form-section mb-4">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>5. IDENTIFICACIÓN OFICIO DE ENTREGA</span>
            <span class="badge bg-success fw-normal" style="font-size:.7rem;letter-spacing:0">
                <i class="fas fa-pencil-alt me-1"></i>Completar para cerrar el registro
            </span>
        </div>
        <div class="section-body">
            <div class="alert alert-warning py-2 small mb-3">
                <i class="fas fa-exclamation-triangle me-1"></i>
                <strong>Atención:</strong> Una vez guardado, el registro quedará bloqueado definitivamente y no podrá modificarse.
            </div>
            <div class="row g-3">

                {{-- Oficio de entrega: spinner + sufijo año automático --}}
                <div class="col-md-5">
                    <label class="form-label">Oficio de Entrega <span class="text-danger">*</span></label>
                    <div class="input-group @error('oficio_nro') is-invalid @enderror">
                        <input type="number" name="oficio_nro" id="oficio_nro"
                            class="form-control @error('oficio_nro') is-invalid @enderror"
                            value="{{ old('oficio_nro') }}"
                            min="1" step="1"
                            placeholder="Nro.">
                        <span class="input-group-text fw-bold" id="sufijo-anio">-{{ date('Y') }}</span>
                    </div>
                    @error('oficio_nro')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    <div class="form-text text-muted" style="font-size:.75rem">Solo ingresa el número — el año se agrega solo.</div>
                </div>

                {{-- Fecha oficio --}}
                <div class="col-md-4">
                    <label class="form-label">Fecha Oficio <span class="text-danger">*</span></label>
                    <input type="date" name="fecha_oficio"
                        class="form-control @error('fecha_oficio') is-invalid @enderror"
                        value="{{ old('fecha_oficio') }}">
                    @error('fecha_oficio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Fila: RUN | Nombre | Cargo --}}
                <div class="col-md-3">
                    <label class="form-label">RUN <span class="text-danger">*</span></label>
                    <input type="text" name="run_receptor" id="run_receptor"
                        class="form-control @error('run_receptor') is-invalid @enderror"
                        value="{{ old('run_receptor') }}"
                        placeholder="Ej: 14.532.871-3"
                        maxlength="12"
                        autocomplete="off">
                    @error('run_receptor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Apellidos receptor <span class="text-danger">*</span></label>
                    <input type="text" name="apellidos_receptor"
                        class="form-control text-uppercase @error('apellidos_receptor') is-invalid @enderror"
                        value="{{ old('apellidos_receptor') }}"
                        placeholder="Ej: SILVA ROJAS">
                    @error('apellidos_receptor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Nombres receptor <span class="text-danger">*</span></label>
                    <input type="text" name="nombres_receptor"
                        class="form-control text-uppercase @error('nombres_receptor') is-invalid @enderror"
                        value="{{ old('nombres_receptor') }}"
                        placeholder="Ej: ANDREA MARCELA">
                    @error('nombres_receptor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-2">
                    <label class="form-label">Cargo <span class="text-danger">*</span></label>
                    <input type="text" name="cargo_receptor"
                        class="form-control text-uppercase @error('cargo_receptor') is-invalid @enderror"
                        value="{{ old('cargo_receptor') }}"
                        placeholder="Ej: FISCAL">
                    @error('cargo_receptor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('evidencias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-check-circle me-1"></i> Confirmar Entrega y Cerrar Registro
        </button>
    </div>

    </form>
</div>
</div>

@push('scripts')
<script>
(function () {
    const rutInput = document.getElementById('run_receptor');

    rutInput.addEventListener('input', function () {
        let v = this.value.replace(/[^0-9kK]/g, '').toUpperCase();
        if (v.length > 1) {
            let dv   = v.slice(-1);
            let body = v.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            this.value = body + '-' + dv;
        } else {
            this.value = v;
        }
    });

    document.getElementById('form-entrega').addEventListener('submit', function () {
        // Almacenar sin puntos, conservando el guion: 14532871-3
        rutInput.value = rutInput.value.replace(/\./g, '');
    });
})();
</script>
@endpush

@endsection
