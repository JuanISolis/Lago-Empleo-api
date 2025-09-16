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
        
        return Estudio::create($datos);
    }

    public function show(int $id)
    {
        return Estudio::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
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