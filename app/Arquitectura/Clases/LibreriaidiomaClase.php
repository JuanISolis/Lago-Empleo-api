<?php

namespace App\Arquitectura\Clases;
use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\LibreriaIdioma;
use App\Models\Idioma;

class LibreriaidiomaClase
{
    public function insertarIdioma(string $idioma)
    {
        try {
            // Busca o crea el idioma en la librería
            return LibreriaIdioma::firstOrCreate(['idioma' => $idioma]);
        } catch (\Exception $e) {
            throw new \Exception('Error al insertar el idioma: ' . $e->getMessage());
        }
    }

    public function listarIdiomas()
    {
        try {
            // Devuelve todos los idiomas de la librería
            return LibreriaIdioma::all();
        } catch (\Exception $e) {
            throw new \Exception('Error al listar los idiomas: ' . $e->getMessage());
        }
    }

    public function buscarIdioma(string $busqueda)
    {
        try {
            // Busca idiomas que coincidan con el término de búsqueda
            return LibreriaIdioma::where('idioma', 'like', "%{$busqueda}%")->get();
        } catch (\Exception $e) {
            throw new \Exception('Error al buscar idiomas: ' . $e->getMessage());
        }
    }
}







// class LibreriaidiomaClase 
// {
//     public function listaridioma()
//     {
//         return Idioma::all();
//     }

//     public function crearidioma(array $datos)
//     {
//         return Idioma::create($datos);
//     }

//     public function buscar($busquedaidioma)
//     {
//         $idioma = Libro::where('habilidad', 'like', "%{$busquedaidioma}%")
//             ->get();

//         if ($libros->isEmpty()) {
//             return response()->json(['message' => 'No se encontraron resultados para la búsqueda.'], 404);
//         }

//         return response()->json($idioma, 200);
//     }

// }