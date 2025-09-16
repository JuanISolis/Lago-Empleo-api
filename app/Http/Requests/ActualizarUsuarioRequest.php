<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ci' => [
                'nullable',
                'string',
                'max:20',
                // Asumiendo que tienes el usuario actual para ignorar en unique:
                'unique:usuarios,ci,' . ($this->usuario?->id ?? 'NULL'),
            ],
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Aquí validamos el archivo imagen
            'nombre' => 'nullable|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'sexo' => 'nullable|in:hombre,mujer,otro',
            'contacto' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'ci.unique' => 'Esta cédula ya está registrada.',
            'foto_perfil.image' => 'La foto de perfil debe ser una imagen válida.',
            'foto_perfil.mimes' => 'La foto de perfil debe ser jpg, jpeg o png.',
            'foto_perfil.max' => 'La foto de perfil no puede superar los 2MB.',
            // Otros mensajes...
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validación fallida',
            'errors' => $validator->errors(),
        ], 422));
    }
}
