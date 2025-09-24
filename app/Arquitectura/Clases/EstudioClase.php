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

    public function showByUser($user_id)
    {
        return Estudio::where('postulante_id', $user_id)->first();
    }

    // ⚠️ Cambié la firma para que coincida con PostulanteClase
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
}
