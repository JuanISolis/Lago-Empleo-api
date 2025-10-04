<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarIdiomaRequest extends FormRequest
{
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
            'idioma' => ['sometimes', 'string', 'max:255'],
            'nivel' => ['sometimes', 'string', 'max:255', 'in:Básico,Intermedio,Avanzado,Nativo'],
            'libreria_idiomas_id' => ['sometimes', 'integer', 'exists:libreria_idiomas,id'],
        ];
    }
}
