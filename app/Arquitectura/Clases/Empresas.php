<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Clases\UsuarioClase;

use App\Models\InformacioEmpresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Empresas 
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
        // Subida de imagen opcional
        if (isset($datos['imagen_empresa'])) {
            $datos['imagen_empresa'] = Storage::put('empresas', $datos['imagen_empresa']);
        }

        return InformacioEmpresa::create($datos);
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
