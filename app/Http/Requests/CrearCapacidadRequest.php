<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreCapacidadesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'postulante_id'    => 'required|integer|exists:postulantes,id',
            'user_id'         => 'required|integer|exists:users,id',
            'habilidades'    => 'required|array|min:1',
            'habilidades.*'  => 'required|string|max:100',
            'idiomas'        => 'required|array|min:1',
            'idiomas.*'      => 'required|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'postulante_id.required' => 'El campo postulante es requerido',
            'postulante_id.integer' => 'El campo postulante debe ser un número entero',
            'postulante_id.exists' => 'El postulante seleccionado no existe',
            'user_id.required' => 'El campo usuario es requerido',
            'user_id.integer' => 'El campo usuario debe ser un número entero',
            'user_id.exists' => 'El usuario seleccionado no existe',
            'habilidades.required' => 'Debe ingresar al menos una habilidad.',
            'idiomas.required' => 'Debe ingresar al menos un idioma.',
            'habilidades.*.required' => 'Cada habilidad debe tener texto.',
            'idiomas.*.required' => 'Cada idioma debe tener texto.',

        ];
    }
}
