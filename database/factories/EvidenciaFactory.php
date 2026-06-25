<?php

namespace Database\Factories;

use App\Models\Evidencia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Evidencia> */
class EvidenciaFactory extends Factory
{
    private static int $contador = 1;

    private array $descripciones = [
        'RUC' => [
            'Video de respaldo CCTV — fijación fotográfica del sitio del suceso. Integridad verificada mediante hash SHA-256.',
            'Grabación de cámara corporal durante procedimiento policial en vía pública. Material remitido por solicitud fiscal.',
            'Registro audiovisual de extracción de evidencia balística en dependencias del cuartel. Sin edición ni cortes detectados.',
            'Secuencia de video de circuito cerrado que acredita trayecto del imputado. Cadena de custodia iniciada en terreno.',
        ],
        'RIT' => [
            'Audio de entrevista a testigo protegido e inspección de registro técnico institucional. Copia certificada adjunta.',
            'Material audiovisual solicitado por Tribunal de Garantía para audiencia de formalización. Entregado bajo protocolo SIP.',
            'Grabación de reconocimiento en rueda de personas efectuado en dependencias del cuartel. Firma digital del operador registrada.',
            'Video panorámico de sitio del suceso con marcación pericial. Transferido al perito audiovisual del Ministerio Público.',
        ],
    ];

    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['RUC', 'RIT']);
        $numero = $tipo === 'RUC'
            ? $this->faker->numerify('#########') . '-' . $this->faker->randomElement(['0','1','2','3','4','5','6','7','8','9','K'])
            : $this->faker->randomElement(['O','C','P','RIT']) . '-' . $this->faker->numberBetween(1, 999) . '-' . date('Y');

        $operadorId = User::where('rol', 'operador')->value('id') ?? 1;

        return [
            'codigo'              => 'EVID-' . str_pad(static::$contador++, 3, '0', STR_PAD_LEFT),
            'tipo_identificador'  => $tipo,
            'numero_identificador'=> $numero,
            'descripcion'         => $this->faker->randomElement($this->descripciones[$tipo]),
            'fecha_ingreso'       => $this->faker->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'integridad_verificada' => $this->faker->boolean(70),
            'operador_id'         => $operadorId,
        ];
    }
}
