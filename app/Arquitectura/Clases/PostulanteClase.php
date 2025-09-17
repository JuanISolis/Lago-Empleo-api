<?php


namespace App\Arquitectura\Clases;

use App\Models\Postulante;



class PostulanteClase extends UsuarioClase
{
    public function obtenerTodos()
    {
        return Postulante::all();
    }

    public function crear(array $datos)
    {
        $authUser = auth()->user();
    
        if (!isset($authUser->usuario)) {
            throw new \Exception('El usuario autenticado no tiene una relación "usuario".');
        }
    
        $datos['usuario_id'] = $authUser->usuario->id;
    
        return Postulante::create($datos);
    }


    public function show()
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        // Pasamos por usuario -> postulante
        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario', 404);
        }

        $postulante = $usuario->postulante;

        if (!$postulante) {
            throw new \Exception('No se encontraron datos de postulante para este usuario', 404);
        }

        return $postulante;
    }


    public function actualizar(array $datos)
    {
        //Linea añadida para verificar que el usuario autenticado es el propietario del postulante
        $usuarioAutenticado = auth()->user();

        $usuarioAutenticado=$usuarioAutenticado->usuario->id??null;

        // if (!isset($datos['id'])) {
        //     return response()->json(['error' => 'Falta el ID del postulante'], 400);
        // }    Posible solucion encontrada pero es fallida

        
        $postulante = Postulante::find($id);

        if (!$postulante) {
            throw new \Exception( 'Postulante no encontrado', 404);
        }
        //Lineas añadidas para verificar que el usuario autenticado es el propietario del postulante

        if ($postulante->user_id !== $usuarioAutenticado->id) {
            throw new \Exception('No tienes permiso para actualizar este postulante', 403);
        }

        $postulante->update($datos);

        return response()->json([
            'message' => 'Postulante actualizado correctamente',
            'postulante' => $postulante
        ], 200);
    }
}