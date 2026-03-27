<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEstudioRequest extends FormRequest
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

        'postulante_id' => 'required|exists:postulantes,id',
        'titulo' => 'required|string|max:255',
        'unidad_educativa' => 'required|string|max:255',
        'modalidad' => 'required|in:presencial,virtual,semi-presencial',
        'doc_titulo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
}
