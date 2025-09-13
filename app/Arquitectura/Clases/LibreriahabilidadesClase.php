<?php

namespace App\Arquitectura\Clases;   
use App\Models\Habilidad; 
use App\Models\LibreriaHabilidad; 
use App\Arquitectura\Interfaces\MercadoLaboral;

        
class LibreriahabilidadClase
{
    public function listar()
    {
        return LibreriaHabilidad::all();
    }

    public function crear($habilidad)
    {
        return LibreriaHabilidad::firstOrCreate(['habilidad' => $habilidad]);
    }

    public function buscar($busqueda)
    {
        return LibreriaHabilidad::where('habilidad', 'like', "%{$busqueda}%")->get();
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