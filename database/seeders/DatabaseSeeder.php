<?php

namespace Database\Seeders;

use App\Models\Evidencia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'name'            => 'ALARCÓN LAGOS CARLOS DANIEL',
                'apellidos'       => 'ALARCÓN LAGOS',
                'nombres'         => 'CARLOS DANIEL',
                'rut'             => '00000000-0',   // actualizar con RUT real
                'email'           => 'c.alarcon@sicea.cl',
                'rol'             => 'operador',
                'cod_funcionario' => '017222-L',
                'grado'           => 'CABO 2DO.',
                'unidad'          => '1RA. COMISARIA SANTIAGO',
            ],
            [
                'name'            => 'PÉREZ MUÑOZ JORGE ANDRÉS',
                'apellidos'       => 'PÉREZ MUÑOZ',
                'nombres'         => 'JORGE ANDRÉS',
                'rut'             => '12345678-9',
                'email'           => 'operador@sicea.cl',
                'rol'             => 'operador',
                'cod_funcionario' => '004821-K',
                'grado'           => 'CABO 1RO.',
                'unidad'          => '1RA. COMISARIA SANTIAGO',
            ],
            [
                'name'            => 'RAMÍREZ VEGA CLAUDIO IGNACIO',
                'apellidos'       => 'RAMÍREZ VEGA',
                'nombres'         => 'CLAUDIO IGNACIO',
                'rut'             => '23456789-0',
                'email'           => 'sip@sicea.cl',
                'rol'             => 'sip',
                'cod_funcionario' => '007334-M',
                'grado'           => 'SARGENTO 2DO.',
                'unidad'          => '1RA. COMISARIA SANTIAGO',
            ],
            [
                'name'            => 'MORALES CISTERNAS PABLO ESTEBAN',
                'apellidos'       => 'MORALES CISTERNAS',
                'nombres'         => 'PABLO ESTEBAN',
                'rut'             => '34567890-1',
                'email'           => 'jefatura@sicea.cl',
                'rol'             => 'jefatura',
                'cod_funcionario' => '001122-J',
                'grado'           => 'CAPITÁN',
                'unidad'          => '1RA. COMISARIA SANTIAGO',
            ],
            [
                'name'            => 'SILVA ROJAS ANDREA MARCELA',
                'apellidos'       => 'SILVA ROJAS',
                'nombres'         => 'ANDREA MARCELA',
                'rut'             => '45678901-2',
                'email'           => 'auditor@sicea.cl',
                'rol'             => 'auditor',
                'cod_funcionario' => '009871-P',
                'grado'           => 'SUBOFICIAL MAYOR',
                'unidad'          => 'SECCIÓN MANTENIMIENTO T.I.C.',
            ],
        ];

        foreach ($usuarios as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['password' => Hash::make('sicea2026')])
            );
        }

        $this->call(EvidenciaSeeder::class);

        // Inicializar contador compartido al máximo existente en evidencias
        DB::table('contadores')->updateOrInsert(
            ['nombre' => 'nro_orden'],
            ['valor'  => Evidencia::max('nro_novedad') ?? 0]
        );
    }
}
