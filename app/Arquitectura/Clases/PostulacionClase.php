<?php

namespace App\Arquitectura\Clases;

use App\Models\Postulacion;

class PostulacionClase
{public function obtenerTodos()
    {
        return Postulacion::all();
    }
public function crear(array $datos)
    {
        return Postulacion::create($datos);
    }

    public function show(int $id)
    {
        return Postulacion::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
    {
        $postulacion = Postulacion::findOrFail($id);
    public function actualizar(array $datos)
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario autenticado no encontrado.', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('Usuario asociado no encontrado.', 404);
        }

        $postulacionId = $datos['postulacion_id'] ?? null;

        if (!$postulacionId) {
            throw new \Exception('ID de postulación no especificado.', 400);
        }

        // Buscar la postulación del postulante autenticado
        $postulacion = Postulacion::where('id', $postulacionId)->first();

        if (!$postulacion) {
            throw new \Exception('Postulación no encontrada o no pertenece al usuario.', 404);
        }

        \Log::info('📦 Datos que van a actualizarse en la BD (servicio):', $datos);

        // Quitar el campo postulacion_id para evitar que intente actualizarlo
        unset($datos['postulacion_id']);

        $postulacion->update($datos);

        \Log::info('📦 Datos actualizados:', $postulacion->toArray());

        return $postulacion;
    }



}