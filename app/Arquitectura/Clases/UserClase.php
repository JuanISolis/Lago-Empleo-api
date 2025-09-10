<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserClase implements MercadoLaboral{
    
    public function obtenerTodos()
    {
        return User::all();
    }

    public function crear(array $datos)
    {
        try {
            $datos['password'] = Hash::make($datos['password']);

            unset($datos['repeatpassword']);

            $user = User::create($datos);

            $token = $user->createToken('token_de_acceso')->plainTextToken;

            return [
                'mensaje' => 'Usuario creado exitosamente.',
                'token' => $token
            ];

        } catch (\Exception $e) {
            return [
                'mensaje' => 'Ocurrió un error al crear el usuario.',
                'error' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500,
                'reset' => false
            ];
        }
    }

    public function show(int $id)
    {

        try {
            $user = User::find($id);
        
            if (!$user) {
                throw new \Exception('Usuario no encontrado.', 404);
            }
        
            return [
                'mensaje' => 'Usuario encontrado correctamente.',
                'usuario' => $user
            ];
        
        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }
    }

    public function actualizar(array $datos)
    {
        $usuarioAutenticado= auth()->user();
        
        if (!$usuarioAutenticado) {
            throw new \Exception('Usuario no encontrado.', 404);
        }
        
        $datosResetPass = collect($datos)
        ->except(['repeatpassword'])
        ->merge([
            'password' => bcrypt($datos['password']),
            'recuperacion' => false,
            ])
        ->toArray();

        $actualizado = $usuarioAutenticado->update($datosResetPass);

        if (!$actualizado) {
            $usuarioAutenticado->currentAccessToken()?->delete();
            throw new \Exception('No se guardó correctamente la nueva contraseña.', 500);
        }

        return [
            'mensaje' => 'Contraseña actualizada correctamente',
            'recuperacion' => false
        ];


    }

}