<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\ExperienciaLaboral;

class Experiencia_laboralClase extends PostulanteClase 
{
    public function obtenerTodos()
    {
        return Experiencialaboral ::all();
    }

    public function crear(array $datos)
    {
        $authUser = auth()->user();

        // Verificar que el usuario tenga un postulante
        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        // Asignar el postulante_id correcto
        $datos['postulante_id'] = $authUser->usuario->postulante->id;
        
        return ExperienciaLaboral::create($datos);
    }

    public function show()
    {
        return ExperienciaLaboral::findOrFail($id);
    }

    public function actualizar(array $datos)
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