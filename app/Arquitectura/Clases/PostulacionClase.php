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

    public function show(array $datos)
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario.', 404);
        }

        $empresaId = $datos['empresa_id'];
        $ofertaLaboralId = $datos['ofertalaboral_id'];

        // 🔍 Acceder a la colección de empresas del usuario (asumimos hasMany)
        $empresa = $usuario->informacionEmpresa
            ->where('id', $empresaId)
            ->first();

        if (!$empresa) {
            throw new \Exception('Empresa no encontrada o no pertenece al usuario.', 404);
        }

        // 🔍 Acceder a la colección de ofertas laborales
        $ofertaLaboral = $empresa->ofertaLaboral
            ->where('id', $ofertaLaboralId)
            ->first();

        if (!$ofertaLaboral) {
            throw new \Exception('Oferta laboral no encontrada en esta empresa.', 404);
        }

        // 🔍 Acceder a las postulaciones de la oferta laboral
        $postulaciones = Postulacion::where('ofertalab_id', $ofertaLaboral->id)->get();

        if (!$postulaciones || $postulaciones->isEmpty()) {
            throw new \Exception('No se encontraron postulaciones para esta oferta laboral.', 404);
        }

        return $postulaciones;
    }




}