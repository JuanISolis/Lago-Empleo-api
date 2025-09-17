<?php

namespace App\Arquitectura\Clases;

use App\Models\Estudio;

class EstudioClase extends PostulanteClase
{
    public function obtenerTodos()
    {
        $authUser = auth()->user(); // usuario autenticado

    if (!$authUser) {
        throw new \Exception('Usuario no autenticado', 401);
    }

    $usuario = $authUser->usuario;

    if (!$usuario) {
        throw new \Exception('No se encontró el perfil de usuario', 404);
    }

    $postulante = $usuario->postulante;

    if (!$postulante) {
        throw new \Exception('No se encontraron datos de postulante para este usuario', 404);
    }

    // Devuelve solo los estudios del postulante autenticado
    return Estudio::where('postulante_id', $postulante->id)->get();
    }

    public function crear(array $datos)
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario', 404);
        }

        $postulante = $usuario->postulante;

        if (!$postulante) {
            throw new \Exception('No se encontraron datos de postulante para este usuario', 404);
        }

        // Relacionar estudio con el postulante autenticado
        $datos['postulante_id'] = $postulante->id;

        return Estudio::create($datos);
    }

    public function show()
    {
        // return Estudio::findOrFail($id);
    }

    public function actualizar(array $datos)
    {
        // linea para obtener el usuario autenticado
        $usuarioAutenticado = auth()->user();

        $estudio = Estudio::findOrFail($id);
        // lineas para verificar si el usuario autenticado es el propietario del estudio
        if ($estudio->user_id !== $usuarioAutenticado->id) {
        throw new \Exception('No tienes permiso para actualizar este estudio.', 403);
        }
        $estudio->update($datos);
        return $estudio;
    }
}