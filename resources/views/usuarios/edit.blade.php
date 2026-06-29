@extends('layouts.app')

@section('title', 'Editar Funcionario')
@section('page-title', 'EDITAR DATOS DEL FUNCIONARIO')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background-color:var(--sicea-verde); color:white;">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-user-edit me-2"></i>{{ $usuario->nombre_display }}
                    <span class="ms-2 badge" style="background-color:var(--sicea-lima); color:var(--sicea-verde-dark); font-size:.65rem;">
                        Cód. {{ $usuario->cod_funcionario }}
                    </span>
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                    @csrf @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" name="apellidos"
                                   value="{{ old('apellidos', $usuario->apellidos) }}"
                                   class="form-control form-control-sm @error('apellidos') is-invalid @enderror"
                                   style="text-transform:uppercase;">
                            @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Nombres <span class="text-danger">*</span></label>
                            <input type="text" name="nombres"
                                   value="{{ old('nombres', $usuario->nombres) }}"
                                   class="form-control form-control-sm @error('nombres') is-invalid @enderror">
                            @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Grado <span class="text-danger">*</span></label>
                            <input type="text" name="grado"
                                   value="{{ old('grado', $usuario->grado) }}"
                                   class="form-control form-control-sm @error('grado') is-invalid @enderror">
                            @error('grado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Código Funcionario</label>
                            <input type="text" value="{{ $usuario->cod_funcionario }}"
                                   class="form-control form-control-sm bg-light" disabled>
                            <div class="form-text" style="font-size:.72rem;">El código de funcionario no se puede modificar.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Unidad <span class="text-danger">*</span></label>
                            <input type="text" name="unidad"
                                   value="{{ old('unidad', $usuario->unidad) }}"
                                   class="form-control form-control-sm @error('unidad') is-invalid @enderror">
                            @error('unidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Rol en el sistema <span class="text-danger">*</span></label>
                            <select name="rol" class="form-select form-select-sm @error('rol') is-invalid @enderror">
                                <option value="operador"  {{ old('rol', $usuario->rol) === 'operador'  ? 'selected' : '' }}>Operador</option>
                                <option value="sip"       {{ old('rol', $usuario->rol) === 'sip'       ? 'selected' : '' }}>Personal S.I.P.</option>
                                <option value="jefatura"  {{ old('rol', $usuario->rol) === 'jefatura'  ? 'selected' : '' }}>Jefatura</option>
                                <option value="auditor"   {{ old('rol', $usuario->rol) === 'auditor'   ? 'selected' : '' }}>Auditor T.I.C.</option>
                            </select>
                            @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Correo institucional <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   value="{{ old('email', $usuario->email) }}"
                                   class="form-control form-control-sm @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <hr class="my-1">
                            <p class="text-muted mb-2" style="font-size:.78rem;">
                                <i class="fas fa-info-circle me-1"></i>
                                Deje los campos de contraseña en blanco para no cambiarla.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Nueva contraseña</label>
                            <input type="password" name="password"
                                   class="form-control form-control-sm @error('password') is-invalid @enderror"
                                   placeholder="Mínimo 8 caracteres">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:.82rem;">Confirmar nueva contraseña</label>
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
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
