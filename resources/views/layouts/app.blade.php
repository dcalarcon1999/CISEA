<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/sicea.css') }}?v={{ filemtime(public_path('css/sicea.css')) }}">
    <title>SICEA — @yield('title', 'Panel de Control')</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        {{-- Menú lateral --}}
        @php $user = auth()->user(); @endphp
        <div class="col-md-3 col-lg-2 side-menu d-flex flex-column">

            {{-- Logo institucional --}}
            <div class="text-center pt-3 pb-2 px-2">
                <img src="{{ asset('images/logo-carabineros.png') }}"
                     alt="Carabineros de Chile"
                     style="width:72px; height:72px; object-fit:contain; filter: drop-shadow(0 1px 3px rgba(0,0,0,.35))">
            </div>

            {{-- Nombre del sistema --}}
            <div class="text-center pb-2 px-2">
                <h5 class="fw-bold mb-0" style="color: var(--sicea-fondo); letter-spacing:2px;">SICEA</h5>
                <p class="mb-0" style="font-size:.65rem; color: var(--sicea-fondo); opacity:.75; letter-spacing:.4px; line-height:1.3">
                    CONTROL DE EVIDENCIA AUDIOVISUAL
                </p>
            </div>

            <hr style="border-color: rgba(255,255,255,.2); margin: 2px 8px 6px;">

            {{-- Identificación del usuario en sesión --}}
            <div class="px-2 pb-2">
                <div style="background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.13); border-radius:5px; padding:8px 10px;">
                    <p class="mb-1" style="font-size:.6rem; color:var(--sicea-lima); font-weight:700; letter-spacing:.5px; text-transform:uppercase">
                        <i class="fas fa-id-badge me-1"></i>Usuario en sesión
                    </p>
                    <p class="mb-0 fw-bold" style="font-size:.78rem; color:var(--sicea-fondo); line-height:1.3">
                        {{ $user->nombre_display }}
                    </p>
                    @if($user->grado)
                    <p class="mb-0" style="font-size:.68rem; color:var(--sicea-fondo); opacity:.8">
                        {{ $user->grado }}
                    </p>
                    @endif
                    @if($user->cod_funcionario)
                    <p class="mb-0" style="font-size:.65rem; color:var(--sicea-fondo); opacity:.65">
                        Cód. {{ $user->cod_funcionario }}
                    </p>
                    @endif
                    @if($user->unidad)
                    <p class="mb-0 mt-1" style="font-size:.63rem; color:var(--sicea-fondo); opacity:.65; line-height:1.2">
                        {{ $user->unidad }}
                    </p>
                    @endif
                    {{-- Badge del rol --}}
                    <span class="badge mt-2" style="font-size:.6rem; letter-spacing:.4px; background-color:var(--sicea-lima); color:var(--sicea-verde-dark)">
                        {{ strtoupper(match($user->rol) {
                            'operador' => 'Operador',
                            'sip'      => 'Personal S.I.P.',
                            'jefatura' => 'Jefatura',
                            'auditor'  => 'Auditor T.I.C.',
                            default    => $user->rol,
                        }) }}
                    </span>
                </div>
            </div>

            <hr style="border-color: rgba(255,255,255,.15); margin: 4px 8px 6px;">

            {{-- Navegación según rol --}}
            <ul class="list-unstyled flex-grow-1">

                @if($user->rol === 'operador')
                <li class="nav-item {{ request()->routeIs('constancias.*') ? 'active' : '' }}">
                    <a href="{{ route('constancias.index') }}" class="nav-link text-white px-2 py-2">
                        <i class="fas fa-book-open me-2"></i>Constancias de Monitoreo
                    </a>
                </li>

                @elseif($user->rol === 'sip')
                <li class="nav-item {{ request()->routeIs('evidencias.*') ? 'active' : '' }}">
                    <a href="{{ route('evidencias.index') }}" class="nav-link text-white px-2 py-2">
                        <i class="fas fa-folder-open me-2"></i>Módulo Evidencias
                    </a>
                </li>

                @elseif($user->rol === 'jefatura')
                <li class="nav-item {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                    <a href="{{ route('reportes.index') }}" class="nav-link text-white px-2 py-2">
                        <i class="fas fa-chart-line me-2"></i>Reportes y Fiscalización
                    </a>
                </li>

                @elseif($user->rol === 'auditor')
                <li class="nav-item {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                    <a href="{{ route('reportes.index') }}" class="nav-link text-white px-2 py-2">
                        <i class="fas fa-chart-line me-2"></i>Reportes
                    </a>
                </li>
                <hr style="border-color: rgba(255,255,255,.1); margin: 4px 0;">
                <li class="nav-item {{ request()->routeIs('auditoria.*') ? 'active' : '' }}">
                    <a href="{{ route('auditoria.index') }}" class="nav-link text-white px-2 py-2">
                        <i class="fas fa-shield-alt me-2"></i>Logs de Auditoría
                    </a>
                </li>
                <hr style="border-color: rgba(255,255,255,.1); margin: 4px 0;">
                <li class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                    <a href="#" class="nav-link text-white px-2 py-2 opacity-50" title="Disponible en Sprint 5">
                        <i class="fas fa-users-cog me-2"></i>Gestión de Usuarios
                    </a>
                </li>
                @endif

            </ul>

        </div>

        {{-- Contenido principal --}}
        <div class="col-md-9 col-lg-10 p-0">
            <nav class="main-navbar d-flex justify-content-between align-items-center px-4 py-3">
                <h3 class="mb-0 text-white fw-semibold sicea-page-title">@yield('page-title', 'LIBRO DIGITAL DE REGISTRO DE NOVEDADES')</h3>
                <div class="d-flex align-items-center gap-3">
                    <span class="small fw-semibold" style="color: var(--sicea-lima); letter-spacing:.3px">
                        <i class="fas fa-lock me-1"></i>Entorno Seguro
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="mb-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light fw-semibold" style="font-size:.78rem;letter-spacing:.3px">
                            <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                        </button>
                    </form>
                </div>
            </nav>

            <div class="container-fluid mt-4 px-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-1"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

    </div>
</div>

<footer class="footer text-center fixed-bottom" style="padding: 4px 0 5px;">
    <img src="{{ asset('images/logo-TIC.png') }}"
         alt="Dirección de Tecnologías de la Información y las Comunicaciones"
         style="height:22px; width:auto; opacity:.65; vertical-align:middle; margin-bottom:2px">
    <p class="mb-0" style="font-size:.7rem; line-height:1.2">
        SICEA &nbsp;—&nbsp; Dirección de Tecnologías de la Información y las Comunicaciones &nbsp;|&nbsp; Portafolio de Proyectos 2026
    </p>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
@stack('scripts')
</body>
</html>
