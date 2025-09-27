<?php


namespace App\Arquitectura\Clases;

use app\Arquitectura\Clases\Empleador;
use App\Models\OfertaLaboral;
use Illuminate\Support\Facades\Storage;

class OfertaLaboralClase 
{
    // Obtener todas las ofertas laborales
    public function obtenerTodos()
    {
        // with('usuario') trae también información del usuario dueño
        return OfertaLaboral::with('usuario')->get();
    }

    // Crear nueva oferta laboral
   public function crear(array $datos)
    {
        try {
            // Obtener usuario autenticado
            $authUser = auth()->user();
            $usuario = $authUser->usuario;

            if (!$usuario) {
                throw new \Exception('Usuario asociado no encontrado.', 404);
            }

            // Validar que la empresa indicada pertenece a este usuario
            $empresaId = $datos['informacion_empresa_id'] ?? null;

            if (!$empresaId) {
                throw new \Exception('Debe seleccionar una empresa válida para publicar la oferta.', 422);
            }

            $empresa = $usuario->informacionEmpresa()->where('id', $empresaId)->first();

            if (!$empresa) {
                throw new \Exception('No tienes permiso para publicar ofertas en esta empresa.', 403);
            }

            // Crear la oferta laboral
            $oferta = OfertaLaboral::create($datos);

            return [
                'mensaje' => 'Oferta creada correctamente.',
                'oferta' => $oferta
            ];

        } catch (\Exception $e) {
            // Registrar error en los logs para facilitar el debugging
            \Log::error('Error al crear oferta laboral', [
                'error' => $e->getMessage(),
                'codigo' => $e->getCode(),
                'usuario_id' => auth()->id(),
                'datos_enviados' => $datos
            ]);

            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }
    }



    // Mostrar una oferta laboral por id
    public function show()
    {
        $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario.', 404);
        }

        $empresas = $usuario->informacionEmpresa;

        if ($empresas->isEmpty()) {
            throw new \Exception('No se encontraron empresas asociadas a este usuario.', 404);
        }

        $ofertasLaborales = $empresas->flatMap(function ($empresa) {
            return $empresa->ofertaLaboral;
        });

        if ($ofertasLaborales->isEmpty()) {
            throw new \Exception('No se encontraron ofertas laborales publicadas.', 404);
        }

        return $ofertasLaborales;
    }


    // Actualizar oferta laboral
    public function actualizar(array $datos)
    {
        $authUser = auth()->user();
        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('Usuario asociado no encontrado.', 404);
        }
    
        $ofertaLaboralId = $datos['ofertalaboral_id'] ?? null;

        if (!$ofertaLaboralId) {
            throw new \Exception('ID de oferta laboral no especificado.', 400);
        }

        $ofertaLaboral = $empresa->ofertasLaborales()->where('id', $ofertaLaboralId)->first();

        if (!$ofertaLaboral) {
            throw new \Exception('Oferta laboral no encontrada o no pertenece a la empresa.', 404);
        }

        // Limpiar campos para evitar problemas
        unset($datos['ofertalaboral_id']);

        \Log::info('📦 Datos que van a actualizarse en la BD (servicio):', $datos);

        $ofertaLaboral->update($datos);

        \Log::info('📦 Datos actualizados:', $ofertaLaboral->toArray());

        return $ofertaLaboral;
    }

}