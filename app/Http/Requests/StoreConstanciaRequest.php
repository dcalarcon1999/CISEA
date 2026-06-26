<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConstanciaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string', 'min:5', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'descripcion.required' => 'Debe ingresar el texto de la constancia.',
            'descripcion.min'      => 'La constancia debe tener al menos 5 caracteres.',
            'descripcion.max'      => 'La constancia no puede superar los 500 caracteres.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'descripcion' => strtoupper(trim($this->descripcion ?? '')),
        ]);
    }
}
