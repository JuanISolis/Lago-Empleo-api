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
            'libreria_habilidades_id' => 'required|exists:habilidads,id',
            'habilidads' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('habilidads', 'habilidads')->ignore($this->habilidad_id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'habilidad_id.required' => 'El id de la habilidad es obligatorio.',
            'habilidad_id.exists' => 'El id de la habilidad no existe.',
            'habilidad.string' => 'La habilidad debe ser una cadena de texto.',
            'habilidad.max' => 'La habilidad no puede superar los 255 caracteres.',
            'habilidad.unique' => 'La habilidad ya está registrada.',
        ];
    }
}