<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearPostulacionRequest extends FormRequest
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
            'ofertalab_id'         => 'required|integer|exists:oferta_laborals,id',
            'fecha_postulacion'    => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'ofertalab_id.required' => 'El campo postulante es requerido',
            'ofertalab_id.integer' => 'El campo postulante debe ser un número entero',
            'ofertalab_id.exists' => 'El postulante seleccionado no existe',
            
            'fecha_postulacion.required' => 'La fecha es obligatoria.',
            'fecha_postulacion.date' => 'Debe ser una fecha válida.',

        ];
    }
}
