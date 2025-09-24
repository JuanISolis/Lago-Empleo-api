<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\ExperienciaLaboral;

class Experiencia_laboralClase extends PostulanteClase
{
    public function obtenerTodos()
    {
        return ExperienciaLaboral::all();
    }

    public function crear(array $datos)
    {
        $authUser = auth()->user();

        // Verificar que el usuario tenga un postulante
        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.', 403);
        }

        // Asignar el postulante_id correcto
        $datos['postulante_id'] = $authUser->usuario->postulante->id;

        return ExperienciaLaboral::create($datos);
    }

    public function show(int $id)
    {
        return ExperienciaLaboral::findOrFail($id);
    }

    public function actualizar(array $datos, int $id)
    {
        $usuarioAutenticado = auth()->user();
        $exp = ExperienciaLaboral::findOrFail($id);

        // Validar que el postulante dueño de la experiencia laboral sea el mismo que el del usuario autenticado
        if (
            !$usuarioAutenticado->usuario ||
            !$usuarioAutenticado->usuario->postulante ||
            $exp->postulante_id !== $usuarioAutenticado->usuario->postulante->id
        ) {
            throw new \Exception('No tienes permiso para actualizar esta experiencia laboral.', 403);
        }

        $exp->update($datos);
        return $exp;
    }
}
