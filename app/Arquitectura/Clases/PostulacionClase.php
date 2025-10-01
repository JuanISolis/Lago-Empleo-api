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

            
            $datos['postulante_id'] = $usuarioAutenticado->id;

            $postulacion = Postulacion::create($datos);

            return [
                'postulacion' => $usuario
            ];

        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }

    }

}