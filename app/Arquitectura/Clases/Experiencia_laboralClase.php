<?php

namespace App\Arquitectura\Clases;

use App\Models\ExperienciaLaboral;

class Experiencia_laboralClase extends PostulanteClase 
{
 public function obtenerPorUsuario($userId)
{
    $authUser = auth()->user();

    if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
        return collect(); // devuelve vacío si no tiene perfil
    }

    $postulanteId = $authUser->usuario->postulante->id;

    return ExperienciaLaboral::where('postulante_id', $postulanteId)->get();
}
    public function crear(array $datos)
    {
        $authUser = auth()->user();

        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        $datos['postulante_id'] = $authUser->usuario->postulante->id;

        return ExperienciaLaboral::create($datos);
    }

    // 🔹 Renombrado para evitar conflicto de firma
    public function showById($id)
    {
        return ExperienciaLaboral::findOrFail($id);
    }

    // 🔹 Renombrado para evitar conflicto de firma
    public function actualizarExperiencia($id, array $datos)
    {
        $usuarioAutenticado = auth()->user();
        $exp = ExperienciaLaboral::findOrFail($id);

        if ($exp->postulante_id !== $usuarioAutenticado->usuario->postulante->id) {
            throw new \Exception('No tienes permiso para actualizar esta experiencia laboral.', 403);
        }

        $exp->update($datos);
        return $exp;
    }

    public function eliminar($id)
    {
        $usuarioAutenticado = auth()->user();
        $exp = ExperienciaLaboral::findOrFail($id);

        if ($exp->postulante_id !== $usuarioAutenticado->usuario->postulante->id) {
            throw new \Exception('No tienes permiso para eliminar esta experiencia laboral.', 403);
        }

        $exp->delete();
        return true;
    }
}
