<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\ExperienciaLaboral;

class Experiencia_laboralClase extends PostulanteClase 
{
    public function obtenerTodos()
    {
        return ExperienciaLaboral::all();
    }

    public function crear(array $datos)
    {
        return ExperienciaLaboral::create($datos);
    }

    public function show(int $id)
    {
        return ExperienciaLaboral::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
    {
        $exp = ExperienciaLaboral::findOrFail($id);
        $exp->update($datos);
        return $exp;
    }
}