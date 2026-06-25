@extends('layouts.app')

@section('title', 'Registrar Nueva Novedad')
@section('page-title', 'LIBRO DIGITAL DE REGISTRO DE NOVEDADES — Nueva Novedad')

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
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('evidencias.store') }}">
    @csrf

    {{-- ══════════════════════════════════════════════════════════
         SECCIÓN 1 — IDENTIFICACIÓN NOVEDAD (auto-generada)
    ══════════════════════════════════════════════════════════ --}}
    <div class="form-section mb-3">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>1. IDENTIFICACIÓN NOVEDAD</span>
            <span class="badge bg-secondary fw-normal" style="font-size:.7rem;letter-spacing:0">
                <i class="fas fa-lock me-1"></i>Generado automáticamente
            </span>
        </div>
        <div class="section-body">
            <div class="funcionario-card d-flex align-items-center gap-4 p-3 rounded">
                <div>
                    <i class="fas fa-hashtag fa-2x text-secondary"></i>
                </div>
                <div class="row g-2 flex-grow-1">
                    <div class="col-md-3">
                        <div class="funcionario-label">Nro. Novedad</div>
                        <div class="funcionario-value fw-bold fs-5">{{ $nroSiguiente }}</div>
                    </div>
                    <div class="col-md-9">
                        <div class="funcionario-label">Fecha y Hora de Registro</div>
                        <div class="funcionario-value fw-bold">{{ $ahoraDisplay }}</div>
                        <div class="text-muted" style="font-size:.75rem">
                            Se registrará la fecha y hora exacta del momento de envío del formulario.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECCIÓN 2 — IDENTIFICACIÓN FUNCIONARIO (solo lectura)
    ══════════════════════════════════════════════════════════ --}}
    <div class="form-section mb-3">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>2. IDENTIFICACIÓN FUNCIONARIO</span>
            <span class="badge bg-secondary fw-normal" style="font-size:.7rem;letter-spacing:0">
                <i class="fas fa-lock me-1"></i>Datos del usuario autenticado
            </span>
        </div>
        <div class="section-body">
            <div class="funcionario-card d-flex align-items-center gap-3 p-3 rounded">
                <div class="funcionario-avatar">
                    <i class="fas fa-id-badge fa-2x text-secondary"></i>
                </div>
                <div class="row g-2 flex-grow-1">
                    <div class="col-md-3">
                        <div class="funcionario-label">Cod. Funcionario</div>
                        <div class="funcionario-value">{{ $funcionario->cod_funcionario ?? '—' }}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="funcionario-label">Grado</div>
                        <div class="funcionario-value">{{ $funcionario->grado ?? '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="funcionario-label">Apellidos y Nombre</div>
                        <div class="funcionario-value fw-bold">{{ $funcionario->nombre_display }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="funcionario-label">Unidad</div>
                        <div class="funcionario-value">{{ $funcionario->unidad ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECCIÓN 3 — IDENTIFICACIÓN ESTAMENTO SOLICITANTE
    ══════════════════════════════════════════════════════════ --}}
    <div class="form-section mb-3">
        <div class="section-header">3. IDENTIFICACIÓN ESTAMENTO SOLICITANTE</div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Estamento Solicitante</label>
                    <input type="text" name="estamento_solicitante"
                        class="form-control @error('estamento_solicitante') is-invalid @enderror"
                        value="{{ old('estamento_solicitante') }}"
                        placeholder="Ej: Fiscalía Regional Metropolitana Centro Norte">
                    @error('estamento_solicitante')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Motivo</label>
                    <select name="motivo"
                        class="form-select @error('motivo') is-invalid @enderror">
                        <option value="">— Seleccionar —</option>
                        <option value="CAUSA"                    {{ old('motivo') === 'CAUSA'                    ? 'selected' : '' }}>CAUSA</option>
                        <option value="RIT"                      {{ old('motivo') === 'RIT'                      ? 'selected' : '' }}>RIT</option>
                        <option value="RUC"                      {{ old('motivo') === 'RUC'                      ? 'selected' : '' }}>RUC</option>
                        <option value="DOCUMENTACIÓN ELECTRÓNICA" {{ old('motivo') === 'DOCUMENTACIÓN ELECTRÓNICA' ? 'selected' : '' }}>DOCUMENTACIÓN ELECTRÓNICA</option>
                    </select>
                    @error('motivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Motivo Nro.</label>
                    <input type="text" name="motivo_nro"
                        class="form-control text-uppercase @error('motivo_nro') is-invalid @enderror"
                        value="{{ old('motivo_nro') }}"
                        placeholder="Ej: 2400123456-K  /  O-45-2026  /  C-1188-2026">
                    @error('motivo_nro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECCIÓN 4 — IDENTIFICACIÓN DE GRABACIONES SOLICITADAS
    ══════════════════════════════════════════════════════════ --}}
    <div class="form-section mb-3">
        <div class="section-header">4. IDENTIFICACIÓN DE GRABACIONES SOLICITADAS</div>
        <div class="section-body">
            <div class="row g-3">

                {{-- Desde --}}
                <div class="col-md-4">
                    <label class="form-label">Desde <span class="text-danger">*</span>
                        <span class="text-muted fw-normal" style="font-size:.75rem">(HH:MM DD/MM/AAAA)</span>
                    </label>
                    <input type="datetime-local" name="grabacion_desde" id="grabacion_desde"
                        class="form-control @error('grabacion_desde') is-invalid @enderror"
                        value="{{ old('grabacion_desde') }}">
                    @error('grabacion_desde')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Hasta --}}
                <div class="col-md-4">
                    <label class="form-label">Hasta <span class="text-danger">*</span>
                        <span class="text-muted fw-normal" style="font-size:.75rem">(HH:MM DD/MM/AAAA)</span>
                    </label>
                    <input type="datetime-local" name="grabacion_hasta" id="grabacion_hasta"
                        class="form-control @error('grabacion_hasta') is-invalid @enderror"
                        value="{{ old('grabacion_hasta') }}">
                    <div id="error_hasta" class="text-danger small mt-1" style="display:none">
                        <i class="fas fa-exclamation-circle me-1"></i>HASTA no puede ser anterior a DESDE.
                    </div>
                    @error('grabacion_hasta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Duración calculada --}}
                <div class="col-md-4">
                    <label class="form-label">Duración de grabación</label>
                    <div class="rounded border p-2 bg-light d-flex align-items-center" style="min-height:38px">
                        <i class="fas fa-clock text-secondary me-2"></i>
                        <span id="duracion_resultado" class="text-muted">—</span>
                    </div>
                </div>

                {{-- Tipo de grabación --}}
                <div class="col-md-5">
                    <label class="form-label">Tipo de grabación <span class="text-danger">*</span></label>
                    <select name="tipo_grabacion"
                        class="form-select @error('tipo_grabacion') is-invalid @enderror">
                        <option value="">— Seleccionar —</option>
                        <option value="CCTV UNIDAD"              {{ old('tipo_grabacion') === 'CCTV UNIDAD'              ? 'selected' : '' }}>CCTV Unidad</option>
                        <option value="CCTV VEHÍCULO POLICIAL"   {{ old('tipo_grabacion') === 'CCTV VEHÍCULO POLICIAL'   ? 'selected' : '' }}>CCTV Vehículo Policial</option>
                        <option value="VIDEOCÁMARA CORPORAL"     {{ old('tipo_grabacion') === 'VIDEOCÁMARA CORPORAL'     ? 'selected' : '' }}>Videocámara Corporal</option>
                    </select>
                    @error('tipo_grabacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Identificador --}}
                <div class="col-md-7">
                    <label class="form-label">Equipo Grabador / Vehículo <span class="text-danger">*</span></label>
                    <input type="text" name="identificador_grabacion"
                        class="form-control text-uppercase @error('identificador_grabacion') is-invalid @enderror"
                        value="{{ old('identificador_grabacion') }}"
                        placeholder="Ej: GRABADOR 1RA. COMISARÍA SANTIAGO  /  VEHÍCULO Z-543">
                    @error('identificador_grabacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECCIÓN 5 — BLOQUEADA EN CREACIÓN
    ══════════════════════════════════════════════════════════ --}}
    <div class="form-section mb-4 opacity-50">
        <div class="section-header d-flex justify-content-between align-items-center">
            <span>5. IDENTIFICACIÓN OFICIO DE ENTREGA</span>
            <span class="badge bg-warning text-dark fw-normal" style="font-size:.7rem;letter-spacing:0">
                <i class="fas fa-clock me-1"></i>Se completa después de la extracción
            </span>
        </div>
        <div class="section-body">
            <div class="text-center py-3 text-muted">
                <i class="fas fa-lock fa-2x mb-2 d-block"></i>
                <p class="mb-0 small">Esta sección se habilitará desde la Bandeja Principal<br>
                una vez registrada la solicitud de extracción.</p>
            </div>
        </div>
    </div>

    {{-- Botones --}}
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('evidencias.index') }}" class="btn btn-outline-secondary">
            Cancelar
        </a>
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Registrar Novedad
        </button>
    </div>

    </form>
</div>
</div>

@push('scripts')
<script>
(function () {
    const desdeInput    = document.getElementById('grabacion_desde');
    const hastaInput    = document.getElementById('grabacion_hasta');
    const resultado     = document.getElementById('duracion_resultado');
    const errorHasta    = document.getElementById('error_hasta');
    const form          = document.querySelector('form');

    function calcularDuracion() {
        if (!desdeInput.value || !hastaInput.value) {
            resultado.textContent = '—';
            resultado.className   = 'text-muted';
            errorHasta.style.display = 'none';
            return;
        }

        const desde = new Date(desdeInput.value);
        const hasta = new Date(hastaInput.value);
        const diff  = hasta - desde;

        if (diff < 0) {
            resultado.textContent = '⚠ HASTA anterior a DESDE';
            resultado.className   = 'text-danger fw-semibold';
            errorHasta.style.display = 'block';
            return;
        }

        errorHasta.style.display = 'none';

        const totalMin = Math.floor(diff / 60000);
        const dias     = Math.floor(totalMin / 1440);
        const horas    = Math.floor((totalMin % 1440) / 60);
        const minutos  = totalMin % 60;

        let partes = [];
        if (dias > 0)  partes.push(dias   + ' DÍA'    + (dias   !== 1 ? 'S' : ''));
        if (horas > 0) partes.push(horas  + ' HORA'   + (horas  !== 1 ? 'S' : ''));
        partes.push(minutos + ' MINUTO' + (minutos !== 1 ? 'S' : ''));

        const ultimo = partes.pop();
        const texto  = partes.length ? partes.join(', ') + ' Y ' + ultimo : ultimo;

        resultado.textContent = texto;
        resultado.className   = 'fw-bold text-success';
    }

    desdeInput.addEventListener('change', calcularDuracion);
    hastaInput.addEventListener('change', calcularDuracion);

    form.addEventListener('submit', function (e) {
        if (desdeInput.value && hastaInput.value) {
            if (new Date(hastaInput.value) < new Date(desdeInput.value)) {
                e.preventDefault();
                errorHasta.style.display = 'block';
                hastaInput.focus();
            }
        }
    });
})();
</script>
@endpush

@endsection
