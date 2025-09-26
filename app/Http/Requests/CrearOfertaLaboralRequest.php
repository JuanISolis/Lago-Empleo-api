<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearOfertaLaboralRequest extends FormRequest
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
            'titulo_ofertalaboral' => 'required|string|max:255',
            'descripcion' => 'required|string', // No limitamos con max
            'ubicacion' => 'required|string|max:255',
            'jornada' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'pago' => 'required|numeric',
            'num_trabajadores' => 'required|integer',
            'experiencia' => 'required|string', // Sin max
            'nivel_estudio' => 'required|string|max:255',
            'edad' => 'required|integer',
            // 'estado' => 'sometimes|boolean', 
            'informacion_empresa_id' => 'required|integer|exists:informacion_empresas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo_ofertalaboral.required' => 'El título de la oferta laboral es obligatorio.',
            'titulo_ofertalaboral.string' => 'El título debe ser un texto.',
            'titulo_ofertalaboral.max' => 'El título no debe superar los 255 caracteres.',

            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',

            'ubicacion.required' => 'La ubicación es obligatoria.',
            'ubicacion.string' => 'La ubicación debe ser un texto.',
            'ubicacion.max' => 'La ubicación no debe superar los 255 caracteres.',

            'jornada.required' => 'La jornada es obligatoria.',
            'jornada.string' => 'La jornada debe ser un texto.',
            'jornada.max' => 'La jornada no debe superar los 255 caracteres.',

            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',

            'pago.required' => 'El campo de pago es obligatorio.',
            'pago.numeric' => 'El pago debe ser un número válido.',

            'num_trabajadores.required' => 'El número de trabajadores es obligatorio.',
            'num_trabajadores.integer' => 'El número de trabajadores debe ser un número entero.',

            'experiencia.required' => 'La experiencia es obligatoria.',
            'experiencia.string' => 'La experiencia debe ser un texto válido.',

            'nivel_estudio.required' => 'El nivel de estudio es obligatorio.',
            'nivel_estudio.string' => 'El nivel de estudio debe ser un texto.',
            'nivel_estudio.max' => 'El nivel de estudio no debe superar los 255 caracteres.',

            'edad.required' => 'La edad es obligatoria.',
            'edad.integer' => 'La edad debe ser un número entero.',

            'estado.boolean' => 'El estado debe ser verdadero (true) o falso (false).',

            'informacion_empresa_id.required' => 'Debes seleccionar la empresa a la que pertenece esta oferta.',
            'informacion_empresa_id.integer' => 'El identificador de la empresa debe ser un número entero.',
            'informacion_empresa_id.exists' => 'La empresa seleccionada no existe o no está registrada.',
        ];
    }



}
