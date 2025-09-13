<?php

namespace App\Arquitectura\Clases;
use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\LibreriaIdioma;
use App\Models\Idioma;

class LibreriaidiomaClase
{
    public function listar()
    {
        return LibreriaIdioma::all();
    }

    public function crear($idioma)
    {
        return LibreriaIdioma::firstOrCreate(['idioma' => $idioma]);
    }

    public function buscar($busqueda)
    {
        return LibreriaIdioma::where('idioma', 'like', "%{$busqueda}%")->get();
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