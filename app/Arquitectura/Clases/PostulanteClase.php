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
        $usuarioAutenticado = auth()->user();
        $datos['user_id'] = $usuarioAutenticado->id;

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

    public function actualizar(array $datos)
    {
        //Linea añadida para verificar que el usuario autenticado es el propietario del postulante
        $usuarioAutenticado = auth()->user();

        // if (!isset($datos['id'])) {
        //     return response()->json(['error' => 'Falta el ID del postulante'], 400);
        // }    Posible solucion encontrada pero es fallida

        
        $postulante = Postulante::find($id);

        if (!$postulante) {
            return response()->json(['error' => 'Postulante no encontrado'], 404);
        }
        //Lineas añadidas para verificar que el usuario autenticado es el propietario del postulante

        if ($postulante->user_id !== $usuarioAutenticado->id) {
        return response()->json(['error' => 'No tienes permiso para actualizar este postulante'], 403);
        }

        $postulante->update($datos);

        return response()->json([
            'message' => 'Postulante actualizado correctamente',
            'postulante' => $postulante
        ], 200);
    }
}