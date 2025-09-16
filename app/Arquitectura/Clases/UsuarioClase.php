<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\Usuario;

class UsuarioClase implements MercadoLaboral{
    
    public function obtenerTodos()
    {
        return Usuario::all();
    }

    public function crear(array $datos)
    {
        
        try {
            $usuarioAutenticado = auth()->user();

            if (!$usuarioAutenticado) {
                throw new \Exception('Usuario no autenticado.', 401);
            }

            // Asociar el ID del usuario autenticado
            $datos['user_id'] = $usuarioAutenticado->id;

            $usuario = Usuario::create($datos);

            return [
                'mensaje' => 'Perfil creado correctamente.',
                'perfil' => $usuario
            ];

        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }

    }


    public function show(int $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {

            return response()->json(['message' => 'Usuario no encontrado'], 404);

        }

        return $usuario;
    }

    public function actualizar(array $datos)
    {
        $usuario = auth()->user(); // Usuario autenticado

        if (!$usuario) {
            throw new \Exception('Usuario no autenticado.', 401);
        }

        $usuario->update($datos); // Actualiza solo los campos enviados
        return $usuario;
    }

    public function perfil()
    {
        try {
            $usuarioAutenticado = auth()->user();
        
            if (!$usuarioAutenticado) {
                throw new \Exception('Usuario no autenticado.', 401);
            }
        
            // Buscar el perfil asociado al usuario autenticado
            $usuario = Usuario::where('user_id', $usuarioAutenticado->id)->first();
        
            if (!$usuario) {
                throw new \Exception('Perfil no encontrado.', 404);
            }
        
            return [
                'mensaje' => 'Perfil recuperado correctamente.',
                'perfil' => $usuario
            ];
        
        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }
    }


}