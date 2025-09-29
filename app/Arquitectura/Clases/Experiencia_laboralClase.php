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
        $postulante = $authUser->usuario()->postulante();

        $expid = $datos['experiencia_id'];
    
        if (!$expid) {
            throw new \Exception('ID de esperiencia no especificado.', 400);
        }
    
        // Buscar la empresa que pertenece al usuario
        $experiencia = $postulante->experiencialaboral()->where('id', $expid)->first();
    
        if (!$experiencia) {
            throw new \Exception('Empresa no encontrada o no pertenece al usuario.', 404);
        }
    
        \Log::info('📦 Datos que van a actualizarse en la BD (servicio):', $datos);
    
        // Quitar el campo empresa_id para evitar que intente actualizarlo
        unset($datos['experiencia_id']);
    
        $experiencia->update($datos);
    
        \Log::info('📦 Datos actualizados:', $experiencia->toArray());
    

        return $experiencia;
    }
}