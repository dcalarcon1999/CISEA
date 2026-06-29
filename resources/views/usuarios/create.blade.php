@extends('layouts.app')

@section('title', 'Registrar Funcionario')
@section('page-title', 'REGISTRAR NUEVO FUNCIONARIO')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color:var(--sicea-verde); color:white;">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-user-plus me-2"></i>Datos del Funcionario
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('usuarios.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="apellidos" value="{{ old('apellidos') }}"
                                   class="form-control form-control-sm @error('apellidos') is-invalid @enderror"
                                   placeholder="ALARCÓN LAGOS" style="text-transform:uppercase;">
                            @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Nombres <span class="text-danger">*</span></label>
                            <input type="text" name="nombres" value="{{ old('nombres') }}"
                                   class="form-control form-control-sm @error('nombres') is-invalid @enderror"
                                   placeholder="Carlos Daniel">
                            @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Grado <span class="text-danger">*</span></label>
                            <input type="text" name="grado" value="{{ old('grado') }}"
                                   class="form-control form-control-sm @error('grado') is-invalid @enderror"
                                   placeholder="CABO 2DO.">
                            @error('grado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Código de Funcionario <span class="text-danger">*</span></label>
                            <input type="text" name="cod_funcionario" value="{{ old('cod_funcionario') }}"
                                   class="form-control form-control-sm @error('cod_funcionario') is-invalid @enderror"
                                   placeholder="017222-L">
                            @error('cod_funcionario') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Unidad <span class="text-danger">*</span></label>
                            <input type="text" name="unidad" value="{{ old('unidad') }}"
                                   class="form-control form-control-sm @error('unidad') is-invalid @enderror"
                                   placeholder="1RA. COMISARÍA SANTIAGO">
                            @error('unidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Rol en el sistema <span class="text-danger">*</span></label>
                            <select name="rol" class="form-select form-select-sm @error('rol') is-invalid @enderror">
                                <option value="">— Seleccione —</option>
                                <option value="operador"  {{ old('rol') === 'operador'  ? 'selected' : '' }}>Operador</option>
                                <option value="sip"       {{ old('rol') === 'sip'       ? 'selected' : '' }}>Personal S.I.P.</option>
                                <option value="jefatura"  {{ old('rol') === 'jefatura'  ? 'selected' : '' }}>Jefatura</option>
                                <option value="auditor"   {{ old('rol') === 'auditor'   ? 'selected' : '' }}>Auditor T.I.C.</option>
                            </select>
                            @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Correo institucional <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror"
                                   placeholder="c.alarcon@sicea.cl">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control form-control-sm @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Confirmar contraseña <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                   class="form-control form-control-sm"
                                   placeholder="Repita la contraseña">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-sm fw-semibold"
                                style="background-color:var(--sicea-verde); color:white;">
                            <i class="fas fa-save me-1"></i>Registrar Funcionario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
