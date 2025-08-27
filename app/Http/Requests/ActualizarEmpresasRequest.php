<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ActualizarEmpresasRequest extends FormRequest
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
            'ruc' =>['required','integer', Rule::unique('informacio_empresas, ruc ')->ignore()],
            'nombre_empresa' => 'required|string|max:255',
            'descripcion' => 'required|string',
            
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
