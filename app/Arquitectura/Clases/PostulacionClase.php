<?php

namespace App\Arquitectura\Clases;

use App\Models\Postulacion;
use App\Models\Actividad;
use App\Models\User;

class PostulacionClase {
    
    public function crear(array $datos)
    {
        try {
            $usuarioAutenticado = auth()->user();

            if (!$usuarioAutenticado) {
                throw new \Exception('Usuario no autenticado.', 401);
            }

            $postulante = $usuarioAutenticado->usuario->postulante;
            $datos['postulante_id'] = $postulante->id;

            \Log::info('📦 Datos que van a crearse en la BD (servicio):', $datos);

            $postulacion = Postulacion::create($datos);

            \Log::info('📦 Datos creados:', $postulacion->toArray());

            // ✅ Crear actividad para notificar al empleador
            $oferta = $postulacion->OfertaLaboral;
            $empresa = $oferta?->informacionEmpresa;
            $usuarioEmpresa = $empresa?->usuario;
            $empleador = $usuarioEmpresa?->user;


            // \Log::info('Empleador (dump): ' . print_r($empleador, true));


            if ($empleador) {
                $actividad = Actividad::create([
                    'tipo' => 'postulacion_realizada',
                    'descripcion' => 'Una Persona se ha postulado a tu oferta: ' . $oferta->titulo_ofertalaboral,
                    'rol' => 'empleador',
                    'user_id' => $empleador->id,
                ]);

                \Log::info('Actividad creada', $actividad->toArray());

            }

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

        $postulacion = Postulacion::where('id', $postulacionId)->first();

        if (!$postulacion) {
            throw new \Exception('Postulación no encontrada o no pertenece al usuario.', 404);
        }

        \Log::info('📦 Datos que van a actualizarse en la BD (servicio):', $datos);

        unset($datos['postulacion_id']);

        $postulacion->update($datos);

        \Log::info('📦 Datos actualizados:', $postulacion->toArray());

        // ✅ Crear actividad según aceptación o rechazo
        $postulanteUser = $postulacion->Postulante->usuario->user ?? null;

        if ($postulanteUser) {
            $estado = $postulacion->estado; // Booleano true o false
            $tipo = $estado ? 'postulante_aceptado' : 'postulante_rechazado';
            $descripcion = $estado
                ? 'Fuiste aceptado en la oferta: ' . $postulacion->ofertalaboral->titulo_ofertalaboral
                : 'Tu postulación fue rechazada en la oferta: ' . $postulacion->ofertalaboral->titulo_ofertalaboral;

            Actividad::create([
                'tipo' => $tipo,
                'descripcion' => $descripcion,
                'rol' => 'postulante',
                'user_id' => $postulanteUser->id,
            ]);

        }

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