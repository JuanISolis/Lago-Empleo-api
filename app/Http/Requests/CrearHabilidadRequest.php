<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearHabilidadRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validación fallida',
            'errors' => $validator->errors()
        ], 422));
    }
	/**
	 * Determina si el usuario está autorizado para hacer esta solicitud.
	 */
	public function authorize() : bool
	{
		return true;
	}

	public function rules()
	{
		return [
			'habilidad' => 'required|string|max:255', 'regex:/^[\pL\s\-]+$/u' // Solo letras, espacios y guiones
		];
	}
    public function messages() : array
    {
        return [
            'habilidad.max' => 'El campo habilidad no debe exceder los 255 caracteres.',
        ];
    }
}


