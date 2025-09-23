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
            'ruc' => 'required|string|unique:informacion_empresas,ruc',
            'nombre_empresa' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen_empresa' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            
        ];

        
    }

    public function messages(): array
    {
        return [
            'ruc.unique' => 'El RUC ya está registrado.',
            'usuario_id.exists' => 'El usuario no existe.',
            'imagen_empresa.image' => 'La foto de perfil debe ser una imagen válida.',
            'imagen_empresa.mimes' => 'La foto de perfil debe ser jpg, jpeg o png.',
            'imagen_empresa.max' => 'La foto de perfil no puede superar los 2MB.'
        ];
    }
}
