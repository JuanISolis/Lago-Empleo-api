<?php

namespace App\Arquitectura\Clases;

use App\Models\Postulacion;

class PostulacionClase
{public function obtenerTodos()
    {
        return Postulacion::all();
    }
public function crear(array $datos)
    {
        return Postulacion::create($datos);
    }

    public function show(int $id)
    {
        return Postulacion::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
    {
        $postulacion = Postulacion::findOrFail($id);
        $postulacion->update($datos);
        return $postulacion;
    }


}