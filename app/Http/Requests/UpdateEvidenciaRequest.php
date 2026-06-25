<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvidenciaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'oficio_nro'         => ['required', 'integer', 'min:1'],
            'oficio_entrega'     => ['required', 'string', 'max:20'],
            'fecha_oficio'       => ['required', 'date'],
            'run_receptor'       => ['required', 'string', 'max:12'],
            'apellidos_receptor' => ['required', 'string', 'max:80'],
            'nombres_receptor'   => ['required', 'string', 'max:80'],
            'cargo_receptor'     => ['required', 'string', 'max:120'],
        ];
    }

    public function messages(): array
    {
        return [
            'oficio_nro.required'         => 'El número de oficio es obligatorio.',
            'oficio_nro.integer'          => 'El número de oficio debe ser un número entero.',
            'oficio_nro.min'              => 'El número de oficio debe ser mayor a 0.',
            'fecha_oficio.required'       => 'La fecha del oficio es obligatoria.',
            'run_receptor.required'       => 'El RUN de quien recibe es obligatorio.',
            'apellidos_receptor.required' => 'Los apellidos de quien recibe son obligatorios.',
            'nombres_receptor.required'   => 'Los nombres de quien recibe son obligatorios.',
            'cargo_receptor.required'     => 'El cargo de quien recibe es obligatorio.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'oficio_entrega'     => ($this->oficio_nro ?? '') . '-' . date('Y'),
            'run_receptor'       => strtoupper(trim($this->run_receptor       ?? '')),
            'apellidos_receptor' => strtoupper(trim($this->apellidos_receptor ?? '')),
            'nombres_receptor'   => strtoupper(trim($this->nombres_receptor   ?? '')),
            'cargo_receptor'     => strtoupper(trim($this->cargo_receptor     ?? '')),
        ]);
    }
}
