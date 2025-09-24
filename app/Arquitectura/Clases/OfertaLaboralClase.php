<?php


namespace App\Arquitectura\Clases;

use app\Arquitectura\Clases\Empleador;
use app\Models\OfertaLaboral;
use Illuminate\Support\Facades\Storage;

class OfertaLaboralClase extends Empleador 
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

            $authUser = auth()->user();

            $usuario = $authUser->usuario;

            if (!$usuario) {
                throw new \Exception('Usuario asociado no encontrado.', 404);
            }

            $empresa = $usuario->informacionEmpresa;

            $datos['informacion_empresa_id'] = $empresa->id;

            return OfertaLaboral::create($datos);

            return [
                'mensaje' => 'Perfil creado correctamente.',
                'empresa' => $empresa
            ];

        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }
    }

    // Mostrar una oferta laboral por id
    public function show(int $id)
    {
        return OfertaLaboral::with('usuario')->findOrFail($id);
    }

    // Actualizar oferta laboral
    public function actualizar(array $datos, string $id)
    {
        $oferta = OfertaLaboral::findOrFail($id);
        $oferta->update($datos);
        return $oferta;
    }
}