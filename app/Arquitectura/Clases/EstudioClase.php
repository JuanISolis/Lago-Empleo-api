<?php

namespace App\Arquitectura\Clases;

use App\Models\Estudio;

class EstudioClase extends PostulanteClase
{
    // Obtener estudios de un usuario específico
    public function obtenerPorUsuario($user_id)
    {
        return Estudio::where('postulante_id', $user_id)->get();
    }

    // Crear un estudio
    public function crear(array $datos)
    {
        return Estudio::create($datos);
    }

    // Mostrar un estudio de un usuario (opcional)
    public function showByUser($user_id)
    {
        return Estudio::where('postulante_id', $user_id)->first();
    }

    // Actualizar un estudio
    public function actualizar(array $datos)
    {
        if (!isset($datos['id'])) {
            throw new \Exception('ID del estudio no proporcionado', 400);
        }

        $estudio = Estudio::find($datos['id']);
        if (!$estudio) {
            throw new \Exception('Estudio no encontrado', 404);
        }

        $estudio->update($datos);
        return $estudio;
    }

    // Buscar un estudio por ID
    public function buscar($id)
    {
        return Estudio::find($id);
    }
}
