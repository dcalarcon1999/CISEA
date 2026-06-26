<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/sicea.css') }}?v={{ filemtime(public_path('css/sicea.css')) }}">
    <title>SICEA — Acceso al Sistema</title>
    <style>
        body {
            min-height: 100vh;
            background-color: var(--sicea-verde-dark);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-bottom: 0;
        }

        .login-card {
            background: #ffffff;
            border-radius: 6px;
            box-shadow: 0 8px 32px rgba(0,0,0,.35);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            background-color: var(--sicea-verde-dark);
            border-bottom: 3px solid var(--sicea-lima);
            padding: 28px 24px 20px;
            text-align: center;
        }

        .login-body {
            padding: 28px 32px 24px;
        }

        .login-footer-bar {
            background-color: var(--sicea-fondo);
            border-top: 1px solid var(--sicea-gris-light);
            padding: 10px 24px;
            text-align: center;
        }

        .form-control:focus {
            border-color: var(--sicea-verde);
            box-shadow: 0 0 0 .2rem rgba(29,125,77,.2);
        }

        .input-group-text {
            background-color: var(--sicea-fondo);
            border-color: var(--sicea-gris-light);
            color: var(--sicea-gris-mid);
        }

        footer.login-page-footer {
            background-color: var(--sicea-verde-hover);
            border-top: 1px solid rgba(255,255,255,.1);
            padding: 8px 0;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>
<body>

<div class="d-flex flex-grow-1 align-items-center justify-content-center py-4">
    <div class="login-card">

        {{-- Cabecera --}}
        <div class="login-header">
            <img src="{{ asset('images/logo-carabineros.png') }}"
                 alt="Carabineros de Chile"
                 style="width:72px;height:72px;object-fit:contain;filter:drop-shadow(0 1px 4px rgba(0,0,0,.4));margin-bottom:12px">

            <h4 class="fw-bold mb-0" style="color:var(--sicea-fondo);letter-spacing:3px;">SICEA</h4>
            <p class="mb-0" style="font-size:.65rem;color:var(--sicea-fondo);opacity:.75;letter-spacing:.5px;line-height:1.4">
                SISTEMA DE CONTROL DE EVIDENCIA AUDIOVISUAL
            </p>
            <p class="mb-0 mt-1" style="font-size:.6rem;color:var(--sicea-lima);opacity:.9;letter-spacing:.3px">
                Carabineros de Chile &mdash; Dirección TIC
            </p>
        </div>

        {{-- Formulario --}}
        <div class="login-body">

            @if($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:.82rem;">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:.82rem;">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="cod_funcionario" class="form-label fw-semibold" style="font-size:.82rem;color:var(--sicea-gris-texto)">
                        Código de Funcionario
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-id-badge" style="font-size:.8rem"></i>
                        </span>
                        <input type="text"
                               id="cod_funcionario"
                               name="cod_funcionario"
                               class="form-control @error('cod_funcionario') is-invalid @enderror"
                               placeholder="ej: 000000-A"
                               value="{{ old('cod_funcionario') }}"
                               autocomplete="username"
                               maxlength="8"
                               autofocus
                               inputmode="numeric"
                               style="text-transform:uppercase;letter-spacing:.05em">
                    </div>
                    <div class="form-text" style="font-size:.7rem;color:var(--sicea-gris-mid)">
                        Ingrese su código de funcionario institucional (ej: 000000-A)
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold" style="font-size:.82rem;color:var(--sicea-gris-texto)">
                        Contraseña Institucional
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock" style="font-size:.8rem"></i>
                        </span>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               autocomplete="current-password">
                        <button type="button"
                                class="input-group-text"
                                style="cursor:pointer;border-left:none"
                                onclick="togglePassword()"
                                title="Mostrar / ocultar contraseña">
                            <i id="eye-icon" class="fas fa-eye" style="font-size:.8rem"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary fw-semibold" style="letter-spacing:.4px">
                        <i class="fas fa-sign-in-alt me-2"></i>Ingresar al Sistema
                    </button>
                </div>
            </form>
        </div>

        {{-- Pie de tarjeta --}}
        <div class="login-footer-bar">
            <p class="mb-0" style="font-size:.68rem;color:var(--sicea-gris-mid)">
                <i class="fas fa-shield-alt me-1" style="color:var(--sicea-verde)"></i>
                Acceso restringido a personal autorizado &mdash; Uso interno
            </p>
        </div>

    </div>
</div>

{{-- Footer institucional --}}
<footer class="login-page-footer">
    <img src="{{ asset('images/logo-TIC.png') }}"
         alt="Dirección TIC"
         style="height:18px;width:auto;opacity:.55;vertical-align:middle;margin-bottom:2px">
    <p class="mb-0" style="font-size:.65rem;color:rgba(255,255,255,.5);line-height:1.3">
        SICEA &nbsp;&mdash;&nbsp; Dirección de Tecnologías de la Información y las Comunicaciones &nbsp;|&nbsp; Portafolio de Proyectos 2026
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

(function () {
    const codInput = document.getElementById('cod_funcionario');

    codInput.addEventListener('keydown', function (e) {
        const val   = this.value;
        const hasDash = val.includes('-');
        const digits  = val.replace(/[^0-9]/g, '');

        // Siempre permitir teclas de control y navegación
        if (e.key === 'Backspace' || e.key === 'Delete' ||
            e.key === 'Tab'       || e.key === 'Escape'  ||
            e.key === 'Enter'     || e.key.startsWith('Arrow')) {
            return;
        }

        // Parte numérica (antes del guion): solo dígitos, máx 6
        if (!hasDash) {
            if (digits.length >= 6 || !/^[0-9]$/.test(e.key)) {
                e.preventDefault();
            }
            return;
        }

        // Parte letra (después del guion): solo letras, máx 1
        const letter = val.split('-')[1] ?? '';
        if (letter.length >= 1 || !/^[A-Za-z]$/.test(e.key)) {
            e.preventDefault();
        }
    });

    codInput.addEventListener('input', function () {
        const cursor = this.selectionStart;
        const clean  = this.value.toUpperCase().replace(/[^0-9A-Z]/g, '');
        const digits = clean.replace(/[A-Z]/g, '').slice(0, 6);
        const letter = clean.replace(/[0-9]/g, '').slice(0, 1);

        const newVal = digits.length === 6 ? digits + '-' + letter : digits;

        if (this.value !== newVal) {
            this.value = newVal;
            // Reposicionar cursor: si el guion fue insertado, avanzar 1
            const offset = newVal.length > digits.length && cursor === 6 ? 1 : 0;
            this.setSelectionRange(cursor + offset, cursor + offset);
        }
    });
})();
</script>
</body>
</html>
