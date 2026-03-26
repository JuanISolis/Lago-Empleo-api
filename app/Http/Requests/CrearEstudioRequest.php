<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEstudioRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validación fallida',
            'errors' => $validator->errors()
        ], 422));
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'postulante_id'    => 'required|integer|exists:postulantes,id',
            'titulo'           => 'required|string|max:255',
            'unidad_educativa' => 'required|string|max:255',
            'modalidad'        => 'required|string|max:255',
            'doc_titulo'       => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'postulante_id.required'    => 'El postulante es obligatorio.',
            'postulante_id.integer'     => 'El postulante debe ser un número entero.',
            'postulante_id.exists'      => 'El postulante seleccionado no existe.',

            'titulo.required'           => 'El título es obligatorio.',
            'titulo.string'             => 'El título debe ser texto.',
            'titulo.max'                => 'El título no puede tener más de 255 caracteres.',

            'unidad_educativa.required' => 'La unidad educativa es obligatoria.',
            'unidad_educativa.string'   => 'La unidad educativa debe ser texto.',
            'unidad_educativa.max'      => 'La unidad educativa no puede tener más de 255 caracteres.',

            'modalidad.required'        => 'La modalidad es obligatoria.',
            'modalidad.string'          => 'La modalidad debe ser texto.',
            'modalidad.max'             => 'La modalidad no puede tener más de 255 caracteres.',

            'doc_titulo.required'       => 'El documento del título es obligatorio.',
            'doc_titulo.string'         => 'El documento del título debe ser texto.',
            'doc_titulo.max'            => 'El documento del título no puede tener más de 255 caracteres.',
        ];
    }
}