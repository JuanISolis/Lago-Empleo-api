<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\Usuario;

class UsuarioClase implements MercadoLaboral{
    
    public function obtenerTodos()
    {
        return Usuario::all();
    }

    public function crear(array $datos)
    {
        return Usuario::create($datos);
    }

    public function show(int $id)
    {
        return Usuario::create($datos);
    }

    public function actualizar(array $datos)
    {
        return Usuario::create($datos);
    }

}