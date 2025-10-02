<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarHabilidadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function failedValidation(Validator $validator)
    {
            throw new HttpResponseException(response()->json([
                'message' => 'Validación fallida',
                'errors' => $validator->errors()
            ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'habilidad_id' => 'required|exists:habilidades,id',
            'habilidad' => 'sometimes|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'habilidad_id.required' => 'El id de la habilidad es obligatorio.',
            'habilidad_id.exists' => 'El id de la habilidad no existe.',
            'habilidad.string' => 'La habilidad debe ser una cadena de texto.',
        ];
    }
}
