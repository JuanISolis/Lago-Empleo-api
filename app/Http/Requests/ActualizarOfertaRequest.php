<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ActualizarOfertaRequest extends FormRequest
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
            'ofertalaboral_id' => 'required|integer|exists:oferta_laborals,id',

            // ✅ Campos opcionales para actualizar
            'titulo_ofertalaboral' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'ubicacion' => 'sometimes|string|max:255',
            'jornada' => 'sometimes|string|max:255',
            'fecha_inicio' => 'sometimes|date',
            'pago' => 'sometimes|numeric',
            'num_trabajadores' => 'sometimes|integer',
            'experiencia' => 'sometimes|string',
            'nivel_estudio' => 'sometimes|string|max:255',
            'edad' => 'sometimes|integer|min:16|max:100',
            'estado' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [

            'ofertalaboral_id.required' => 'El ID de la oferta laboral es obligatorio.',
            'ofertalaboral_id.integer' => 'El ID de la oferta laboral debe ser un número entero.',
            'ofertalaboral_id.exists' => 'La oferta laboral especificada no existe.',

            // Mensajes para campos opcionales
            'titulo_ofertalaboral.string' => 'El título debe ser una cadena de texto.',
            'titulo_ofertalaboral.max' => 'El título no puede tener más de 255 caracteres.',

            'descripcion.string' => 'La descripción debe ser una cadena de texto.',

            'ubicacion.string' => 'La ubicación debe ser una cadena de texto.',
            'ubicacion.max' => 'La ubicación no puede tener más de 255 caracteres.',

            'jornada.string' => 'La jornada debe ser una cadena de texto.',
            'jornada.max' => 'La jornada no puede tener más de 255 caracteres.',

            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',

            'pago.numeric' => 'El pago debe ser un número.',

            'num_trabajadores.integer' => 'El número de trabajadores debe ser un número entero.',

            'experiencia.string' => 'La experiencia debe ser una cadena de texto.',

            'nivel_estudio.string' => 'El nivel de estudio debe ser una cadena de texto.',
            'nivel_estudio.max' => 'El nivel de estudio no puede tener más de 255 caracteres.',

            'edad.integer' => 'La edad debe ser un número entero.',
            'edad.min' => 'La edad mínima permitida es 16 años.',
            'edad.max' => 'La edad máxima permitida es 100 años.',

            'estado.boolean' => 'El estado debe ser verdadero (true) o falso (false).',
        ];
    }
}
