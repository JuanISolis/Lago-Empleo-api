<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces;
use App\Models\Estudio;
use App\Arquitectura\Interfaces\MercadoLaboral;

class EstudioClase implements MercadoLaboral
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

    public function actualizar(array $datos, string $user)
    {
        $estudio = Estudio::findOrFail($datos['id']);
        $estudio->update($datos);
        return $estudio;
    }
}