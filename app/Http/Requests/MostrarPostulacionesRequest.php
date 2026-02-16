<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MostrarPostulacionesRequest extends FormRequest
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
            'empresa_id' => 'required|exists:informacion_empresas,id',
            'ofertalaboral_id' => 'required|exists:oferta_laborals,id',
        ];
    }
    
    public function messages(): array
    {
        return [
            'empresa_id.required' => 'El ID de la empresa es obligatorio.',
            'empresa_id.exists' => 'El ID de la empresa no existe.',

            'ofertalaboral_id.required' => 'El ID de la oferta laboral es obligatorio.',
            'ofertalaboral_id.exists' => 'El ID de la oferta laboral no existe.',
        ];
    }

}
