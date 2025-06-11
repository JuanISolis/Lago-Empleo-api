<?php

namespace App\Arquitectura\Interfaces;

interface Estudios
{
    public function crear(array $datos);
    public function obtenerTodos();
    public function show(int $id);
    public function actualizar(array $datos);
}

