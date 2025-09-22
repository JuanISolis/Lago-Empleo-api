<?php


namespace App\Arquitectura\Clases;

use App\Models\Postulante;



class PostulanteClase extends UsuarioClase
{
    public function obtenerTodos()
    {
        $usuario = auth()->user(); // usuario autenticado
        return Postulante::where('usuario_id', $usuario->usuario->id)->get();
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
        // Validar que venga el ID
       

        // Obtener el usuario autenticado
        $authUser = auth()->user();
        $usuario = $authUser->usuario ?? null;

        if (!$usuario) {
            throw new \Exception('Perfil de usuario no encontrado', 404);
        }

        // Buscar el postulante por ID
        $postulante = Postulante::find($datos['id']);

        if (!$postulante) {
            throw new \Exception('Postulante no encontrado', 404);
        }

        // Verificar que el usuario autenticado sea el dueño del postulante
        if ($postulante->user_id !== $usuario->id) {
            throw new \Exception('No tienes permiso para actualizar este postulante', 403);
        }

        // Eliminar el ID del array de datos para no intentar actualizarlo
        unset($datos['id']);

        // Actualizar el postulante
        $postulante->update($datos);

        return $postulante;
    }

}