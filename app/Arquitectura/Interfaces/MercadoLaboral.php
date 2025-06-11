<?php

namespace App\Arquitectura\Interfaces;

interface MercadoLaboral {

    public function crear(array $datos);
    public function obtenerTodos();
    public function show(int $id);
    public function actualizar(array $datos, string $user);
    
}