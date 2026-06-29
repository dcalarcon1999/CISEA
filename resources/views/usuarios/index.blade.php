@extends('layouts.app')

@section('title', 'Gestión de Usuarios')
@section('page-title', 'GESTIÓN DE FUNCIONARIOS — ADMINISTRACIÓN DE ACCESOS')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('usuarios.create') }}" class="btn btn-sm fw-semibold"
       style="background-color:var(--sicea-verde); color:white; letter-spacing:.3px;">
        <i class="fas fa-user-plus me-1"></i> Registrar Funcionario
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center"
         style="background-color:var(--sicea-verde); color:white;">
        <h6 class="mb-0 fw-semibold">
            <i class="fas fa-users-cog me-2"></i>
            Funcionarios registrados — {{ $usuarios->total() }}
        </h6>
    </div>

    <div class="card-body p-0">
        @if($usuarios->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fas fa-users fa-2x mb-2 d-block" style="opacity:.3"></i>
                No hay funcionarios registrados.
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover table-sm mb-0" style="font-size:.84rem;">
                <thead style="background-color:#f8f9fa;">
                    <tr>
                        <th class="px-3 py-2">Cód. Funcionario</th>
                        <th class="px-3 py-2">Apellidos, Nombres</th>
                        <th class="px-3 py-2">Grado</th>
                        <th class="px-3 py-2">Unidad</th>
                        <th class="px-3 py-2">Rol</th>
                        <th class="px-3 py-2 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td class="px-3 py-2 font-monospace fw-semibold" style="font-size:.8rem;">
                            {{ $usuario->cod_funcionario }}
                        </td>
                        <td class="px-3 py-2">
                            {{ $usuario->nombre_display }}
                            @if($usuario->id === auth()->id())
                                <span class="badge bg-secondary ms-1" style="font-size:.65rem;">Tú</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-muted">{{ $usuario->grado ?? '—' }}</td>
                        <td class="px-3 py-2 text-muted" style="font-size:.78rem;">{{ $usuario->unidad ?? '—' }}</td>
                        <td class="px-3 py-2">
                            @php
                                $rolBadge = match($usuario->rol) {
                                    'operador'  => ['bg-primary',   'Operador'],
                                    'sip'       => ['bg-warning text-dark', 'Personal S.I.P.'],
                                    'jefatura'  => ['bg-success',   'Jefatura'],
                                    'auditor'   => ['bg-danger',    'Auditor T.I.C.'],
                                    default     => ['bg-secondary', $usuario->rol],
                                };
                            @endphp
                            <span class="badge {{ $rolBadge[0] }}" style="font-size:.7rem;">
                                {{ $rolBadge[1] }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-end text-nowrap">
                            <a href="{{ route('usuarios.edit', $usuario) }}"
                               class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size:.75rem;">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            @if($usuario->id !== auth()->id())
                            <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar a {{ $usuario->nombre_display }}? Esta acción no se puede deshacer.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 ms-1"
                                        style="font-size:.75rem;">
                                    <i class="fas fa-user-minus me-1"></i>Eliminar
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($usuarios->hasPages())
        <div class="px-3 py-2 border-top">
            {{ $usuarios->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
