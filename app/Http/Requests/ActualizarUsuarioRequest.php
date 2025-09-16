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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validación fallida',
            'errors' => $validator->errors()
        ], 422));
    }

    public function rules(): array
    {
        \Log::info(__CLASS__ . ' ejecutado'); // Log de depuración

        $usuario = optional(auth()->user()->usuario);

        return [
            'ci' => [
                'nullable',
                'string',
                'max:20',
                'unique:usuarios,ci,' . $usuario->id,
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

    public function messages(): array
    {
        return [
            'ci.string' => 'La cédula debe ser una cadena de texto.',
            'ci.max' => 'La cédula no puede tener más de 20 caracteres.',
            'ci.unique' => 'Esta cédula ya está registrada en otro perfil.',

            'foto_perfil.image' => 'La foto debe ser una imagen.',
            'foto_perfil.mimes' => 'La imagen debe ser de tipo JPG, JPEG o PNG.',
            'foto_perfil.max' => 'La imagen no debe pesar más de 2MB.',

            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',

            'apellido.string' => 'El apellido debe ser texto.',
            'apellido.max' => 'El apellido no puede tener más de 255 caracteres.',

            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',

            'sexo.in' => 'El sexo debe ser "masculino", "femenino" u "otro".',

            'contacto.string' => 'El contacto debe ser texto.',
            'contacto.max' => 'El contacto no puede tener más de 50 caracteres.',

            'direccion.string' => 'La dirección debe ser texto.',
            'direccion.max' => 'La dirección no puede tener más de 255 caracteres.',
        ];
    }
}
