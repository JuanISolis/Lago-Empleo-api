<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarPostulanteRequest extends FormRequest
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
            'profesion' => ['sometimes', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'string', 'max:1000'],
            'discapacidad' => ['sometimes', 'boolean'],
            'tipo_discapacidad' => ['sometimes', 'nullable', 'string', 'max:255'],
            'porcent_discapacidad' => ['sometimes', 'nullable', 'numeric', 'between:0,100'],
        ];
    }

    public function messages(): array
    {
        return [
            'profesion.string' => 'La profesión debe ser un texto.',
            'profesion.max' => 'La profesión no puede tener más de 255 caracteres.',

            'descripcion.string' => 'La descripción debe ser un texto.',
            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',

            'discapacidad.boolean' => 'El campo discapacidad debe ser verdadero o falso.',

            'tipo_discapacidad.string' => 'El tipo de discapacidad debe ser un texto.',
            'tipo_discapacidad.max' => 'El tipo de discapacidad no puede tener más de 255 caracteres.',

            'porcent_discapacidad.numeric' => 'El porcentaje de discapacidad debe ser un número.',
            'porcent_discapacidad.between' => 'El porcentaje de discapacidad debe estar entre 0 y 100.',
        ];
    }
}
