<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearPostulanteRequest extends FormRequest
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
            // 'user_id' => 'required|integer|exists:usuarios,id',
            'profesion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'discapacidad' => 'required|boolean',
            'tipo_discapacidad' => 'nullable|string',
            'porcent_discapacidad' => 'nullable|integer',
        ];
    }
}