<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearUserRequest extends FormRequest
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
        return 
        [
            'email' => 'required|string|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'repeatpassword' => 'required|string|same:password', 
            'rol' => 'required|string|in:postulante,empleador',
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'La contraseña debe incluir al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'repeatpassword.same' => 'Las contraseñas no coinciden.',
        ];
    }
    
}
