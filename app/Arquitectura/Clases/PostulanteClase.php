<?php


namespace App\Arquitectura\Clases;

use App\Models\Postulante;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;




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
    $authUser = Auth::user();

    // Obtener el postulante del usuario autenticado
    $postulante = $authUser->usuario->postulante ?? null;

    if (!$postulante) {
        throw new NotFoundHttpException('Perfil de postulante no encontrado');
    }


    // Actualizar el postulante
    $postulante->update($datos);

    return $postulante;
    }

}