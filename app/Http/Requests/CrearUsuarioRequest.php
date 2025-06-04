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
            'user_id'=> 'required|integer|min:18',
            'ci'=> 'required|integer|min:18',
            'foto_perfil'=> 'required|integer|min:18',
            'apellido'=> 'required|integer|min:18',
            'fecha_nacimiento'=> 'required|integer|min:18',
            'sexo'=> 'required|integer|min:18',
            'contacto'=> 'required|integer|min:18',
            'direccion'=> 'required|integer|min:18',
        ];
    }
}
