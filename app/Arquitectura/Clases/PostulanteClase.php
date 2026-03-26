<?php


namespace App\Arquitectura\Clases;

use App\Models\Postulante;
use App\Arquitectura\Interfaces\MercadoLaboral;

class PostulanteClase implements MercadoLaboral
{
    public function obtenerTodos()
    {
        return Postulante::all();
    }

    public function crear(array $datos)
    {
        return Postulante::create($datos);
    }

    public function show(int $id)
    {
        $postulante = Postulante::find($id);

        if (!$postulante) {
            return response()->json(['message' => 'Postulante no encontrado'], 404);
        }

        return $postulante;
    }

    public function actualizar(array $datos, string $id)
    {
        $postulante = Postulante::find($id);

        if (!$postulante) {
            return response()->json(['error' => 'Postulante no encontrado'], 404);
        }

        $postulante->update($datos);

        return response()->json([
            'message' => 'Postulante actualizado correctamente',
            'postulante' => $postulante
        ], 200);
    }
}