<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            padding: 30px 40px;
        }

        /* Encabezado institucional */
        .header { display: table; width: 100%; margin-bottom: 18px; }
        .header-logo { display: table-cell; width: 70px; vertical-align: middle; }
        .header-logo img { width: 60px; }
        .header-text { display: table-cell; vertical-align: middle; padding-left: 12px; }
        .header-text .inst { font-size: 9px; color: #555; letter-spacing: .3px; text-transform: uppercase; }
        .header-text .sistema { font-size: 13px; font-weight: bold; color: #1d7d4d; letter-spacing: 1px; }
        .header-text .subtitulo { font-size: 9px; color: #555; }
        .header-right { display: table-cell; text-align: right; vertical-align: middle; width: 160px; }
        .header-right .nro-acta { font-size: 18px; font-weight: bold; color: #1d7d4d; }
        .header-right .label { font-size: 8px; color: #777; text-transform: uppercase; letter-spacing: .3px; }

        hr { border: none; border-top: 2px solid #1d7d4d; margin-bottom: 16px; }
        hr.thin { border-top: 1px solid #ccc; margin: 10px 0; }

        /* Título del documento */
        .titulo-doc {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1d7d4d;
            margin-bottom: 4px;
        }
        .subtitulo-doc {
            text-align: center;
            font-size: 9px;
            color: #666;
            margin-bottom: 18px;
            letter-spacing: .4px;
        }

        /* Secciones */
        .seccion { margin-bottom: 14px; }
        .seccion-header {
            background-color: #1d7d4d;
            color: white;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: .5px;
            text-transform: uppercase;
            padding: 4px 8px;
            margin-bottom: 8px;
        }
        .seccion-body { padding: 0 4px; }

        /* Campos */
        .row-campos { display: table; width: 100%; margin-bottom: 6px; }
        .campo { display: table-cell; padding-right: 16px; vertical-align: top; }
        .campo:last-child { padding-right: 0; }
        .campo-label {
            font-size: 8px;
            color: #777;
            text-transform: uppercase;
            letter-spacing: .3px;
            margin-bottom: 2px;
        }
        .campo-valor {
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
            min-height: 16px;
        }
        .campo-valor.normal { font-weight: normal; }

        /* Badge estado */
        .badge-entregado {
            background-color: #1d7d4d;
            color: white;
            padding: 2px 8px;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: .4px;
        }

        /* Firma */
        .firmas { display: table; width: 100%; margin-top: 30px; }
        .firma { display: table-cell; text-align: center; width: 50%; padding: 0 20px; }
        .firma-linea { border-top: 1px solid #333; margin-top: 40px; padding-top: 4px; }
        .firma-nombre { font-size: 10px; font-weight: bold; }
        .firma-cargo { font-size: 9px; color: #555; }

        /* Pie de página */
        .footer {
            margin-top: 24px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            font-size: 8px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>

{{-- Encabezado --}}
<div class="header">
    <div class="header-logo">
        <img src="{{ public_path('images/logo-carabineros.png') }}">
    </div>
    <div class="header-text">
        <div class="inst">Carabineros de Chile</div>
        <div class="sistema">SICEA</div>
        <div class="subtitulo">Sistema Institucional de Control de Evidencia Audiovisual</div>
    </div>
    <div class="header-right">
        <div class="label">N° Novedad</div>
        <div class="nro-acta">{{ str_pad($evidencia->nro_novedad, 3, '0', STR_PAD_LEFT) }}</div>
        <div class="label" style="margin-top:4px">Fecha emisión</div>
        <div style="font-size:10px;font-weight:bold;">{{ now()->format('d/m/Y H:i') }}</div>
    </div>
</div>

<hr>

<div class="titulo-doc">Acta de Entrega de Evidencia Audiovisual</div>
<div class="subtitulo-doc">Anexo N° 1 — Orden General N° 3192 &nbsp;|&nbsp; Cadena de Custodia</div>

{{-- Sección 1: Identificación Novedad --}}
<div class="seccion">
    <div class="seccion-header">1. Identificación de la Novedad</div>
    <div class="seccion-body">
        <div class="row-campos">
            <div class="campo" style="width:25%">
                <div class="campo-label">Nro. Novedad</div>
                <div class="campo-valor">{{ str_pad($evidencia->nro_novedad, 3, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="campo" style="width:35%">
                <div class="campo-label">Fecha y Hora de Registro</div>
                <div class="campo-valor">{{ $evidencia->fecha_novedad->format('d/m/Y H:i:s') }}</div>
            </div>
            <div class="campo" style="width:20%">
                <div class="campo-label">Estado</div>
                <div class="campo-valor"><span class="badge-entregado">ENTREGADO</span></div>
            </div>
        </div>
    </div>
</div>

{{-- Sección 2: Identificación Funcionario --}}
<div class="seccion">
    <div class="seccion-header">2. Identificación del Funcionario</div>
    <div class="seccion-body">
        <div class="row-campos">
            <div class="campo" style="width:20%">
                <div class="campo-label">Cód. Funcionario</div>
                <div class="campo-valor">{{ $evidencia->cod_funcionario }}</div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Grado</div>
                <div class="campo-valor">{{ $evidencia->grado }}</div>
            </div>
            <div class="campo" style="width:38%">
                <div class="campo-label">Apellidos y Nombre</div>
                <div class="campo-valor">{{ $evidencia->apellidos_nombre }}</div>
            </div>
            <div class="campo" style="width:24%">
                <div class="campo-label">Unidad</div>
                <div class="campo-valor normal">{{ $evidencia->unidad }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Sección 3: Estamento Solicitante --}}
<div class="seccion">
    <div class="seccion-header">3. Identificación del Estamento Solicitante</div>
    <div class="seccion-body">
        <div class="row-campos">
            <div class="campo" style="width:50%">
                <div class="campo-label">Estamento Solicitante</div>
                <div class="campo-valor normal">{{ $evidencia->estamento_solicitante }}</div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">Motivo</div>
                <div class="campo-valor">{{ $evidencia->motivo }}</div>
            </div>
            <div class="campo" style="width:32%">
                <div class="campo-label">N° Motivo (RUC / RIT / Causa)</div>
                <div class="campo-valor">{{ $evidencia->motivo_nro }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Sección 4: Grabación Solicitada --}}
<div class="seccion">
    <div class="seccion-header">4. Identificación de Grabaciones Solicitadas</div>
    <div class="seccion-body">
        <div class="row-campos">
            <div class="campo" style="width:28%">
                <div class="campo-label">Desde</div>
                <div class="campo-valor">{{ $evidencia->grabacion_desde?->format('d/m/Y H:i') ?? '—' }}</div>
            </div>
            <div class="campo" style="width:28%">
                <div class="campo-label">Hasta</div>
                <div class="campo-valor">{{ $evidencia->grabacion_hasta?->format('d/m/Y H:i') ?? '—' }}</div>
            </div>
            <div class="campo" style="width:22%">
                <div class="campo-label">Tipo de Grabación</div>
                <div class="campo-valor normal">{{ $evidencia->tipo_grabacion ?? '—' }}</div>
            </div>
            <div class="campo" style="width:22%">
                <div class="campo-label">Equipo / Vehículo</div>
                <div class="campo-valor normal">{{ $evidencia->identificador_grabacion ?? '—' }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Sección 5: Oficio de Entrega --}}
<div class="seccion">
    <div class="seccion-header">5. Identificación del Oficio de Entrega</div>
    <div class="seccion-body">
        <div class="row-campos">
            <div class="campo" style="width:25%">
                <div class="campo-label">Oficio de Entrega</div>
                <div class="campo-valor">{{ $evidencia->oficio_entrega }}</div>
            </div>
            <div class="campo" style="width:22%">
                <div class="campo-label">Fecha del Oficio</div>
                <div class="campo-valor">{{ \Carbon\Carbon::parse($evidencia->fecha_oficio)->format('d/m/Y') }}</div>
            </div>
            <div class="campo" style="width:18%">
                <div class="campo-label">RUN Receptor</div>
                <div class="campo-valor">{{ $evidencia->run_receptor }}</div>
            </div>
            <div class="campo" style="width:35%">
                <div class="campo-label">Apellidos y Nombres Receptor</div>
                <div class="campo-valor">{{ $evidencia->apellidos_receptor }} {{ $evidencia->nombres_receptor }}</div>
            </div>
        </div>
        <div class="row-campos" style="margin-top:4px">
            <div class="campo" style="width:40%">
                <div class="campo-label">Cargo del Receptor</div>
                <div class="campo-valor normal">{{ $evidencia->cargo_receptor }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Firmas --}}
<div class="firmas">
    <div class="firma">
        <div class="firma-linea">
            <div class="firma-nombre">{{ $evidencia->apellidos_nombre }}</div>
            <div class="firma-cargo">{{ $evidencia->grado }} — Funcionario Responsable</div>
        </div>
    </div>
    <div class="firma">
        <div class="firma-linea">
            <div class="firma-nombre">{{ $evidencia->apellidos_receptor }} {{ $evidencia->nombres_receptor }}</div>
            <div class="firma-cargo">{{ $evidencia->cargo_receptor }} — Receptor</div>
        </div>
    </div>
</div>

{{-- Pie --}}
<div class="footer">
    Documento generado automáticamente por SICEA — Dirección de Tecnologías de la Información y las Comunicaciones &nbsp;|&nbsp; {{ now()->format('d/m/Y H:i:s') }}
    <br>Este documento forma parte de la cadena de custodia. Su alteración constituye delito.
</div>

</body>
</html>
