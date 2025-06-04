<?php

namespace App\Abstracts;

abstract class Postulante
{
    public string $ci;
    public string $foto_perfil;
    public string $nombre;
    public string $apellido;
    public string $fecha_nacimiento;
    public string $sexo;
    public string $contacto;
    public string $direccion;
    public string $profesion;
    public string $descripcion;
    public bool $discapacidad;
    public ?string $tipo_discapacidad;
    public ?float $porcent_discapacidad;

    abstract public function registrar(): bool;
}
