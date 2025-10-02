<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ActualizarPostulacionRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'postulacion_id' => 'required|exists:postulacions,id',
            'estado' => 'required|boolean',
        ];
    }
    
    public function messages(): array
    {
        return [
            'postulacion_id.required' => 'El ID de la postulación es obligatorio.',
            'postulacion_id.exists' => 'El ID de la postulación no existe.',
            'estado.required' => 'El campo estado es obligatorio.',
            'estado.boolean' => 'El campo estado debe ser verdadero o falso.',
        ];
    }

}
