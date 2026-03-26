<?php

namespace App\Arquitectura\Clases;

use App\Models\Estudio;

class EstudioClase
{
    public function obtenerTodos()
    {
        return Estudio::all();
    }

    public function crear(array $datos)
    {
        return Estudio::create($datos);
    }

    public function show(int $id)
    {
        return Estudio::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
    {
        $estudio = Estudio::findOrFail($id);
        $estudio->update($datos);
        return $estudio;
    }
}