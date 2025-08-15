<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEmpresaRequest extends FormRequest
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
            'ruc' => 'required|integer|unique:informacio_empresas,ruc',
            'nombre_empresa' => 'required|string|max:255',
            'imagen_empresa' => 'nullable|string',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|exists:usuarios,id'
        ];
    }

    public function messages(): array
    {
        return [
            'ruc.unique' => 'El RUC ya está registrado.',
            'usuario_id.exists' => 'El usuario no existe.'
        ];
    }
}
