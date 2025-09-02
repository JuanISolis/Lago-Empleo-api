<?php

namespace App\Arquitectura\Clases;
use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\Idioma;
use App\Models\Habilidad;
use App\Models\postulante;
use App\Models\LibreriaHabilidad;
use App\Models\LibreriaIdioma;

class CapacidadesClase extends Usuarioclase
{
    public $habilidades = [];
    public $idiomas = [];
    

    public function crear(array $datos)
{
    if (isset($datos['tipo']) && $datos['tipo'] === 'habilidad') {
        // Buscar o crear la habilidad en la librería
        $libreria = LibreriaHabilidad::firstOrCreate([
            'habilidad' => $datos['habilidad']
        ]);
        // Asociar la habilidad al postulante
        return Habilidad::create([
            'libreria_habilidades_id' => $libreria->id,
            'postulante_id' => $datos['postulante_id'],
        ]);
    } elseif (isset($datos['tipo']) && $datos['tipo'] === 'idioma') {
        // Buscar o crear el idioma en la librería
        $libreria = LibreriaIdioma::firstOrCreate([
            'idioma' => $datos['idioma']
        ]);
        // Asociar el idioma al postulante
        return Idioma::create([
            'libreria_idiomas_id' => $libreria->id,
            'postulante_id' => $datos['postulante_id'],
            'nivel' => $datos['nivel'],
        ]);
    }
    throw new \Exception('Tipo de capacidad no reconocido');
    }

    public function obtenerTodos()
    {
        // Devuelve todas las habilidades e idiomas
        return [
            'habilidades' => Habilidad::all(),
            'idiomas' => Idioma::all(),
        ];
    }

    public function show(int $id)
    {
        // Busca una habilidad o idioma por ID
        $habilidad = Habilidad::find($id);
        if ($habilidad) return $habilidad;

        $idioma = Idioma::find($id);
        if ($idioma) return $idioma;

        throw new \Exception('No se encontró la capacidad');
    }

    public function actualizar(array $datos, string $id)
    {
        // Actualiza una habilidad o idioma según el tipo
        if (isset($datos['tipo']) && $datos['tipo'] === 'habilidad') {
            $habilidad = Habilidad::findOrFail($id);
            $habilidad->update($datos);
            return $habilidad;
        } elseif (isset($datos['tipo']) && $datos['tipo'] === 'idioma') {
            $idioma = Idioma::findOrFail($id);
            $idioma->update($datos);
            return $idioma;
        }
        throw new \Exception('Tipo de capacidad no reconocido');
    }
    // ...existing code...
}


