<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvidenciaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Secciones 1 y 2 vienen del servidor — no se validan aquí
            // Sección 3
            'estamento_solicitante'   => ['required', 'string', 'max:120'],
            'motivo'                  => ['required', 'in:CAUSA,RIT,RUC,DOCUMENTACIÓN ELECTRÓNICA'],
            'motivo_nro'              => ['required', 'string', 'max:40'],
            // Sección 4
            'grabacion_desde'         => ['required', 'date'],
            'grabacion_hasta'         => ['required', 'date', 'after_or_equal:grabacion_desde'],
            'tipo_grabacion'          => ['required', 'in:CCTV UNIDAD,CCTV VEHÍCULO POLICIAL,VIDEOCÁMARA CORPORAL'],
            'identificador_grabacion' => ['required', 'string', 'max:120'],
            // Sección 5 — siempre nullable en creación
            'oficio_entrega'          => ['nullable', 'string', 'max:20'],
            'fecha_oficio'            => ['nullable', 'date'],
            'run_receptor'            => ['nullable', 'string', 'max:12'],
            'apellidos_receptor'      => ['nullable', 'string', 'max:80'],
            'nombres_receptor'        => ['nullable', 'string', 'max:80'],
        ];
    }

    public function messages(): array
    {
        return [
            'estamento_solicitante.required'   => 'El estamento solicitante es obligatorio.',
            'motivo.required'                  => 'Debe seleccionar un motivo.',
            'motivo.in'                        => 'El motivo debe ser CAUSA, RIT o RUC.',
            'motivo_nro.required'              => 'El número de motivo es obligatorio.',
            'grabacion_desde.required'         => 'La fecha/hora de inicio de grabación es obligatoria.',
            'grabacion_hasta.required'         => 'La fecha/hora de término de grabación es obligatoria.',
            'grabacion_hasta.after_or_equal'   => 'La fecha/hora de término no puede ser anterior al inicio.',
            'tipo_grabacion.required'          => 'Debe seleccionar el tipo de grabación.',
            'tipo_grabacion.in'                => 'El tipo de grabación seleccionado no es válido.',
            'identificador_grabacion.required' => 'El equipo grabador o vehículo es obligatorio.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'motivo_nro'              => strtoupper(trim($this->motivo_nro              ?? '')),
            'identificador_grabacion' => strtoupper(trim($this->identificador_grabacion ?? '')),
            'run_receptor'            => strtoupper(trim($this->run_receptor            ?? '')),
        ]);
    }
}
