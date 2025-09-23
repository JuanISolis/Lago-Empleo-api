<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\ExperienciaLaboral;

class Experiencia_laboralClase extends PostulanteClase 
{
    public function obtenerTodos()
    {
            // Obtener el usuario autenticado
        $usuarioAutenticado = auth()->user();

        // Obtener el postulante asociado al usuario autenticado
        $postulante = $usuarioAutenticado->postulante;

        // Validar que el postulante exista
        if (!$postulante) {
            throw new \Exception('No se encontraron datos de postulante para este usuario.', 404);
        }

        // Retornar todas las experiencias laborales del postulante
        return $postulante->experienciasLaborales;
    }

    public function crear(array $datos)
    {
        return ExperienciaLaboral::create($datos);
    }

    public function show(int $id)
    {
        return ExperienciaLaboral::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
    {
        // linea para obtener el usuario autenticado
        $usuarioAutenticado = auth()->user();

        $exp = ExperienciaLaboral::findOrFail($id);
        
        // Validar que el usuario autenticado es el propietario de la experiencia laboral
        if ($exp->user_id !== $usuarioAutenticado->id) {
            throw new \Exception('No tienes permiso para actualizar esta experiencia laboral.', 403);
        }
        $exp->update($datos);
        return $exp;
    }
}