<?php

namespace App\Arquitectura\Clases;

use App\Models\InformacionEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmpresasClase 
{
    // Obtener todas las empresas
    public function obtenerTodos($usuario)
    {
        
        return InformacionEmpresa::where('usuario_id', $usuario->id )->get(); 
        // with('usuario') trae también información del usuario dueño
    }

    // Crear nueva empresa
    public function crear(array $datos)
    {
        
        try {

            $usuarioAutenticado = auth()->user();

            if (!$usuarioAutenticado || !$usuarioAutenticado->usuario) {
                throw new \Exception('Usuario no autenticado o sin perfil.', 401);
            }

            $datos['usuario_id'] = $usuarioAutenticado->usuario->id;

    

            $empresa = InformacionEmpresa::create($datos);

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

    // Mostrar una empresa por id
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

        return $empresas;
    }

    // Actualizar empresa
   public function actualizar(array $datos)
    {
        $authUser = auth()->user();

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('Usuario asociado no encontrado.', 404);
        }

        $empresa = $usuario->informacionEmpresa;

        if (!$empresa) {
            throw new \Exception('Empresa no encontrada.', 404);
        }

        \Log::info('📦 Datos que van a actualizarse en la BD (servicio):', $datos);
    

        $empresa->update($datos);

        \Log::info('📦 Datos actualizados:', $empresa->toArray());

        return $empresa;
    }


    
}