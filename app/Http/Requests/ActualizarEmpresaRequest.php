<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ActualizarEmpresaRequest extends FormRequest
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
            'empresa_id' => 'required|exists:informacion_empresas,id',
            'ruc' => [
                'sometimes',
                'integer',
                Rule::unique('informacion_empresas', 'ruc')->ignore($this->empresa_id),
            ],
            'nombre_empresa' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'imagen_empresa' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            'empresa_id.required' => 'El id de la empresa es obligatorio.',
            'empresa_id.exists' => 'El id de la empresa no esxiste.',
            'ruc.unique' => 'El RUC ya está registrado.',
            'usuario_id.exists' => 'El usuario no existe.',
            'imagen_empresa.image' => 'La foto de perfil debe ser una imagen válida.',
            'imagen_empresa.mimes' => 'La foto de perfil debe ser jpg, jpeg o png.',
            'imagen_empresa.max' => 'La foto de perfil no puede superar los 2MB.'
        ];
    }
}
