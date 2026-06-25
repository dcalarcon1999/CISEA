<?php

namespace Database\Seeders;

use App\Models\Evidencia;
use Illuminate\Database\Seeder;

class EvidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $registros = [
            [
                'nro_novedad'            => 1,
                'fecha_novedad'          => '2026-06-10 09:15:00',
                'cod_funcionario'        => '004821-K',
                'grado'                  => 'CABO 1RO.',
                'apellidos_nombre'       => 'PÉREZ MUÑOZ JORGE ANDRÉS',
                'unidad'                 => '3RA COMISARÍA SANTIAGO CENTRO',
                'estamento_solicitante'  => 'Fiscalía Regional Metropolitana Centro Norte',
                'motivo'                 => 'RUC',
                'motivo_nro'             => '2400123456-K',
                'grabacion_desde'        => '2026-06-08 07:00:00',
                'grabacion_hasta'        => '2026-06-08 08:30:00',
                'tipo_grabacion'         => 'CCTV UNIDAD',
                'identificador_grabacion'=> 'GRABADOR 3RA. COMISARÍA SANTIAGO CENTRO',
                'oficio_entrega'         => '41-2026',
                'fecha_oficio'           => '2026-06-12',
                'run_receptor'           => '14532871-3',
                'apellidos_receptor'     => 'SILVA ROJAS',
                'nombres_receptor'       => 'ANDREA MARCELA',
                'cargo_receptor'         => 'FISCAL ADJUNTA',
                'estado'                 => 'entregado',
                'operador_id'            => 2,
            ],
            [
                'nro_novedad'            => 2,
                'fecha_novedad'          => '2026-06-18 14:30:00',
                'cod_funcionario'        => '007334-M',
                'grado'                  => 'SARGENTO 2DO.',
                'apellidos_nombre'       => 'RAMÍREZ VEGA CLAUDIO IGNACIO',
                'unidad'                 => 'TALLER TIC — DIRECCIÓN DE TELECOMUNICACIONES',
                'estamento_solicitante'  => 'Juzgado de Garantía de Santiago',
                'motivo'                 => 'RIT',
                'motivo_nro'             => 'O-45-2026',
                'grabacion_desde'        => '2026-06-15 22:45:00',
                'grabacion_hasta'        => '2026-06-16 01:20:00',
                'tipo_grabacion'         => 'CCTV VEHÍCULO POLICIAL',
                'identificador_grabacion'=> 'VEHÍCULO Z-543',
                'oficio_entrega'         => null,
                'fecha_oficio'           => null,
                'run_receptor'           => null,
                'apellidos_receptor'     => null,
                'nombres_receptor'       => null,
                'cargo_receptor'         => null,
                'estado'                 => 'pendiente',
                'operador_id'            => 3,
            ],
            [
                'nro_novedad'            => 3,
                'fecha_novedad'          => '2026-06-23 11:00:00',
                'cod_funcionario'        => '017222-L',
                'grado'                  => 'CABO 2DO.',
                'apellidos_nombre'       => 'ALARCÓN LAGOS CARLOS DANIEL',
                'unidad'                 => 'SECCIÓN MANTENIMIENTO T.I.C.',
                'estamento_solicitante'  => 'Fiscalía Oriente — Unidad de Delitos Violentos',
                'motivo'                 => 'CAUSA',
                'motivo_nro'             => 'C-1188-2026',
                'grabacion_desde'        => '2026-06-20 00:00:00',
                'grabacion_hasta'        => '2026-06-21 23:59:00',
                'tipo_grabacion'         => 'VIDEOCÁMARA CORPORAL',
                'identificador_grabacion'=> 'CARABINERO PÉREZ MUÑOZ — CREDENCIAL 004821',
                'oficio_entrega'         => '89-2026',
                'fecha_oficio'           => '2026-06-24',
                'run_receptor'           => '17209445-8',
                'apellidos_receptor'     => 'MORALES CISTERNAS',
                'nombres_receptor'       => 'PABLO ESTEBAN',
                'cargo_receptor'         => 'INVESTIGADOR DEL CASO',
                'estado'                 => 'entregado',
                'operador_id'            => 1,
            ],
        ];

        foreach ($registros as $data) {
            Evidencia::firstOrCreate(['nro_novedad' => $data['nro_novedad']], $data);
        }
    }
}
