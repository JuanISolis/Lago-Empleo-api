<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ci' => [
                'nullable',
                'string',
                'max:20',
                'unique:usuarios,ci,' . ($usuario->id ?? 'NULL'), // Ignora el actual si existe
            ],
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nombre' => 'nullable|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'sexo' => 'nullable|in:masculino,femenino,otro',
            'contacto' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ];
    }
}
