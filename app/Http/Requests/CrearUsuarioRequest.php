<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearUsuarioRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id|unique:usuarios,user_id',
            'ci' => 'required|digits:10|unique:usuarios,ci',
            'foto_perfil' => 'nullable|string',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string|in:hombre,mujer',
            'contacto' => 'required|digits:10',
            'direccion' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'El ID de usuario es obligatorio.',
            'user_id.integer' => 'El ID de usuario debe ser un número entero.',
            'user_id.exists' => 'El usuario seleccionado no existe.',

            'ci.required' => 'El campo cédula es obligatorio.',
            'ci.digits' => 'La cédula debe tener exactamente 10 dígitos.',
            'ci.unique' => 'Esta cédula ya está registrada.',

            'foto_perfil.string' => 'La foto de perfil debe ser una cadena de texto.',

            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser texto.',
            'apellido.max' => 'El apellido no puede tener más de 255 caracteres.',

            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',

            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.string' => 'El sexo debe ser texto.',
            'sexo.in' => 'El sexo debe ser "hombre" o "mujer".',

            'contacto.required' => 'El contacto es obligatorio.',
            'contacto.digits' => 'El contacto debe tener exactamente 10 dígitos.',

            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
        ];
    }

}
