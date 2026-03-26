<?php

namespace App\Arquitectura\Clases;
use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\Idioma;

class LibreriaidiomaClase implements MercadoLaboral
{
    public function obtenerTodos()
    {
        return Idioma::all();
    }

    public function crear(array $datos)
    {
        return Idioma::create($datos);
    }

    public function show(int $id)
    {
        return Idioma::findOrFail($id);
    }

    public function actualizar(array $datos, string $id)
    {
        $idioma = Idioma::findOrFail($id);
        $idioma->update($datos);
        return $idioma;
    }
}