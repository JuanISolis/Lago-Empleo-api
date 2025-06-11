<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|max:9999999',
            'ci' => 'required|integer|unique:usuarios,ci',
            'foto_perfil' => 'nullable|string',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string|in:masculino,femenino',
            'contacto' => 'required|integer|max:999999999',
            'direccion' => 'nullable|string|max:255',
        ];
    }
}
