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
         $authUser = auth()->user();

        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        // Obtener el postulante_id desde el usuario autenticado
        $postulanteId = $authUser->usuario->postulante->id;

        // Buscar la experiencia laboral asociada al postulante
        $exp = ExperienciaLaboral::where('postulante_id', $postulanteId)->firstOrFail();

        // Actualizar los datos de la experiencia laboral
        $exp->update($datos);

        return $exp;
    }
}