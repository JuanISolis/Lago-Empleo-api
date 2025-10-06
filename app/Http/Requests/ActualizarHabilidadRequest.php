<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ActualizarHabilidadRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validación fallida',
            'errors' => $validator->errors()
        ], 422));
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Se puede enviar un nuevo nombre de habilidad (campo 'habilidad')
            'habilidad' => [
                'sometimes',
                'string',
                'max:255',
            ],
            // O bien referenciar una librería por id
            'libreria_habilidades_id' => [
                'sometimes',
                'integer',
                'exists:libreria_habilidads,id'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'libreria_habilidades_id.integer' => 'El id de la librería debe ser un número entero.',
            'libreria_habilidades_id.exists' => 'El id de la librería de habilidades no existe.',
            'habilidad.string' => 'La habilidad debe ser una cadena de texto.',
            'habilidad.max' => 'La habilidad no puede superar los 255 caracteres.',
        ];
    }
}