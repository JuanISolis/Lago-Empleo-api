<?php

namespace App\Arquitectura\Clases;

use App\Models\Postulacion;

class PostulacionClase {
    
    public function crear(array $datos)
    {
        
        try {
            $usuarioAutenticado = auth()->user();

            if (!$usuarioAutenticado) {
                throw new \Exception('Usuario no autenticado.', 401);
            }

            
            $datos['postulante_id'] = $usuarioAutenticado->usuario->postulante->id;

            $postulacion = Postulacion::create($datos);

            return [
                'postulacion' => $postulacion
            ];

        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }

    }

    public function actualizar(array $datos)
    {
        $authUser = auth()->user();
    
        $usuario = $authUser->usuario;
    
        if (!$usuario) {
            throw new \Exception('Usuario asociado no encontrado.', 404);
        }
    
        $postulacionId = $datos['postulacion_id'] ?? null;
    
        if (!$postulacionId) {
            throw new \Exception('ID de postulacion no especificado.', 400);
        }
    
        // Buscar la empresa que pertenece al usuario
        $postulacion = $usuario->postulante->postulacion()->where('id', $postulacionId)->first();
    
        if (!$postulacion) {
            throw new \Exception('Postulacion no encontrada o no pertenece al usuario.', 404);
        }
    
        \Log::info('📦 Datos que van a actualizarse en la BD (servicio):', $datos);
    
        // Quitar el campo empresa_id para evitar que intente actualizarlo
        unset($datos['postulacion_id']);
    
        $postulacion->update($datos);
    
        \Log::info('📦 Datos actualizados:', $empresa->toArray());
    
        return $postulacion;
    }

}