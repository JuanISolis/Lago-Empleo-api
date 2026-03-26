<?php

namespace App\Arquitectura\Clases;   
use App\Models\Habilidad; 
use App\Arquitectura\Interfaces\MercadoLaboral;

        
class LibreriahabilidadesClase implements MercadoLaboral
{
    public function obtenerTodos()
    {
        return Habilidad::all();
    }

    public function crear(array $datos)
    {
        return Habilidad::create($datos);
    }

    public function show(int $id)
    {
        return Habilidad::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
    {
        $habilidad = Habilidad::findOrFail($id);
        $habilidad->update($datos);
        return $habilidad;
    }
}