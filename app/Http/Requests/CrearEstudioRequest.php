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
        'titulo'           => 'required|string|max:255',
        'unidad_educativa' => 'string|max:255',
        'cargo'            => 'nullable|string|max:255', // 👈 nuevo campo
        'modalidad'        => 'string|max:255',
        'doc_titulo'       => 'nullable|string|max:255',
    ];
}

public function messages(): array
{
    return [
        'titulo.required'           => 'El título es obligatorio.',
        'titulo.string'             => 'El título debe ser texto.',
        'titulo.max'                => 'El título no puede tener más de 255 caracteres.',

        'unidad_educativa.string'   => 'La unidad educativa debe ser texto.',
        'unidad_educativa.max'      => 'La unidad educativa no puede tener más de 255 caracteres.',

        'cargo.string'              => 'El cargo debe ser texto.', // 👈 nuevo mensaje
        'cargo.max'                 => 'El cargo no puede tener más de 255 caracteres.',

        'modalidad.string'          => 'La modalidad debe ser texto.',
        'modalidad.max'             => 'La modalidad no puede tener más de 255 caracteres.',

        'doc_titulo.string'         => 'El documento del título debe ser texto.',
        'doc_titulo.max'            => 'El documento del título no puede tener más de 255 caracteres.',
    ];
}
}