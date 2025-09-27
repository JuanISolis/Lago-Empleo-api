<?php

namespace App\Arquitectura\Clases;   
use App\Models\Habilidad; 
use App\Models\LibreriaHabilidad; 
use App\Arquitectura\Interfaces\MercadoLaboral;

        
class LibreriahabilidadClase 
{
    public function insertarHabilidad(string $habilidad)
    {
        try {
            // Busca o crea la habilidad en la librería
            return LibreriaHabilidad::firstOrCreate(['habilidad' => $habilidad]);
        } catch (\Exception $e) {
            throw new \Exception('Error al insertar la habilidad: ' . $e->getMessage());
        }
    }

    public function listarHabilidades()
    {
        try {
            // Devuelve todas las habilidades de la librería
            return LibreriaHabilidad::all();
        } catch (\Exception $e) {
            throw new \Exception('Error al listar las habilidades: ' . $e->getMessage());
        }
    }

    public function buscarHabilidad(string $busqueda)
    {
        try {
            // Busca habilidades que coincidan con el término de búsqueda
            return LibreriaHabilidad::where('habilidad', 'like', "%{$busqueda}%")->get();
        } catch (\Exception $e) {
            throw new \Exception('Error al buscar habilidades: ' . $e->getMessage());
        }
    }
}










// class LibreriahabilidadesClase 
// {
//     public function failedValidation(Validator $validator)
//     {
//         throw new HttpResponseException(response()->json([
//             'message' => 'Validación fallida',
//             'errors' => $validator->errors()
//         ], 422));
//     }

//     public function listarhabilidad()
//     {
//         return Habilidad::all();
//     }

//     public function crearhabilidad(array $datos)
//     {
//         return Habilidad::create($datos);
//     }

//     public function buscar($busquedahabilidad)
//     {
//         $habilidad = Libro::where('habilidad', 'like', "%{$busquedahabilidad}%")
//             ->get();

//         if ($libros->isEmpty()) {
//             return response()->json(['message' => 'No se encontraron resultados para la búsqueda.'], 404);
//         }

//         return response()->json($habilidad, 200);
//     }
// }