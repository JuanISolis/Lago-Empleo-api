<?php


namespace App\Arquitectura\Clases;

use app\Arquitectura\Clases\Empleador;
use app\Models\OfertaLaboral;
use Illuminate\Support\Facades\Storage;

class OfertaLaboralClase extends Empleador 
{
    // Obtener todas las ofertas laborales
    public function obtenerTodos()
    {
        // with('usuario') trae también información del usuario dueño
        return OfertaLaboral::with('usuario')->get();
    }

    // Crear nueva oferta laboral
    public function crear(array $datos)
    {
        return OfertaLaboral::create($datos);
    }

    // Mostrar una oferta laboral por id
    public function show(int $id)
    {
        return OfertaLaboral::with('usuario')->findOrFail($id);
    }

    // Actualizar oferta laboral
    public function actualizar(array $datos, string $id)
    {
        $oferta = OfertaLaboral::findOrFail($id);
        $oferta->update($datos);
        return $oferta;
    }
}