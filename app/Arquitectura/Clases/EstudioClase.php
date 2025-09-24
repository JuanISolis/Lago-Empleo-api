<?php

namespace App\Arquitectura\Clases;

use App\Models\Estudio;

class EstudioClase extends PostulanteClase
{
    public function obtenerTodos()
    {
        return Estudio::all();
    }

    public function crear(array $datos)
    {
        $authUser = auth()->user();

        // Verificar que el usuario tenga un postulante
        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        // Asignar el postulante_id correcto
        $datos['postulante_id'] = $authUser->usuario->postulante->id;

        // Crear el estudio
        $authUser = auth()->user();

        // Verificar que el usuario tenga un postulante
        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        // Asignar el postulante_id correcto
        $datos['postulante_id'] = $authUser->usuario->postulante->id;

        // Crear el estudio
        return Estudio::create($datos);
    }


    

    public function show()
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario', 404);
        }

        $estudio = Estudio::where('user_id', $usuario->id)->first();

        if (!$estudio) {
            throw new \Exception('No se encontró el estudio para este usuario', 404);
        }

        return $estudio;
    }

    public function actualizar(array $datos)
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario', 404);
        }

        $estudio = Estudio::where('user_id', $usuario->id)->first();

        if (!$estudio) {
            throw new \Exception('No se encontró el estudio para este usuario', 404);
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario', 404);
        }

        $estudio = Estudio::where('user_id', $usuario->id)->first();

        if (!$estudio) {
            throw new \Exception('No se encontró el estudio para este usuario', 404);
        }

        return $estudio;
    }

    public function actualizar(array $datos)
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario', 404);
        }

        $estudio = Estudio::where('user_id', $usuario->id)->first();

        if (!$estudio) {
            throw new \Exception('No se encontró el estudio para este usuario', 404);
        }


        $estudio->update($datos);


        return $estudio;
    }
}
