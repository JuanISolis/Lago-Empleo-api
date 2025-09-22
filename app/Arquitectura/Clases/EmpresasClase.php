<?php

namespace App\Arquitectura\Clases;

use App\Models\InformacioEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmpresasClase 
{
    // Obtener todas las empresas
    public function obtenerTodos($usuario)
    {
        
        return InformacioEmpresa::where('usuario_id', $usuario->id )->get(); 
        // with('usuario') trae también información del usuario dueño
    }

    // Crear nueva empresa
    public function crear(array $datos)
    {
        
        try {

            $usuarioAutenticado = auth()->user();

            if (!$usuarioAutenticado) {
                throw new \Exception('Usuario no autenticado.', 401);
            }
    
            $datos['usuario_id'] = $usuarioAutenticado->usuario->id;

            $usuario = InformacioEmpresa::create($datos);

            return [
                'mensaje' => 'Perfil creado correctamente.',
                'perfil' => $usuario
            ];

        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'codigo' => $e->getCode() ?: 500
            ];
        }

    }

    // Mostrar una empresa por id
    public function show(int $id)
    {
        $empresa = InformacioEmpresa::with('usuario')->find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        return $empresa;
    }

    // Actualizar empresa
    public function actualizar(array $datos, int $id)
    {
        $empresa = InformacioEmpresa::find($id);

        if (!$empresa) {
            return response()->json(['message' => 'Empresa no encontrada'], 404);
        }

        // Subida de imagen opcional
        if (isset($datos['imagen_empresa'])) {
            $datos['imagen_empresa'] = Storage::put('empresas', $datos['imagen_empresa']);
        }

        $empresa->update($datos);

        return $empresa;
    }

    
}
