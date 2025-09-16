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
        $postulante = Postulante::create($datos);
        $token = $postulante->createToken('auth_token')->plainTextToken;

        return [
            'usuario' => $postulante,
            'token' => $token
        ];
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
    $usuarioAutenticado = auth()->user();
    $postulante = Postulante::where('user_id', $usuarioAutenticado->id)->first();

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