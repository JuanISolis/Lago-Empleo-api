<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearEstudioRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            // 'postulante_id'    => 'required|integer|exists:postulantes,id',
            'titulo'           => 'required|string|max:255',
            'unidad_educativa' => 'string|max:255',
            'modalidad'        => 'string|max:255',
            'doc_titulo'       => 'nullable|file|mimes:pdf|max:2048', // <---- esto permite null


        ];
        if ($request->hasFile('doc_titulo')) {
        $file = $request->file('doc_titulo'); // Esto sí es un UploadedFile
        $nombreArchivo = $file->getClientOriginalName();

        // Guardar archivo
        $ruta = $file->storeAs('titulos', $nombreArchivo, 'public');
}
    }

    public function messages(): array
    {
        return [
            'postulante_id.required'    => 'El postulante es obligatorio.',
            'postulante_id.integer'     => 'El postulante debe ser un número entero.',
            'postulante_id.exists'      => 'El postulante seleccionado no existe.',

            'titulo.required'           => 'El título es obligatorio.',
            'titulo.string'             => 'El título debe ser texto.',
            'titulo.max'                => 'El título no puede tener más de 255 caracteres.',

            'unidad_educativa.required' => 'La unidad educativa es obligatoria.',
            'unidad_educativa.string'   => 'La unidad educativa debe ser texto.',
            'unidad_educativa.max'      => 'La unidad educativa no puede tener más de 255 caracteres.',

            'modalidad.required'        => 'La modalidad es obligatoria.',
            'modalidad.string'          => 'La modalidad debe ser texto.',
            'modalidad.max'             => 'La modalidad no puede tener más de 255 caracteres.',

            'doc_titulo.file' => 'El documento debe ser un archivo válido.',
            'doc_titulo.mimes' => 'El documento debe ser un archivo PDF.',
            'doc_titulo.max' => 'El documento no puede superar los 2 MB.',
        ];
    }
}