<?php

namespace App\Arquitectura\Clases;
use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\Idioma;
use App\Models\Habilidad;
use App\Models\postulante;
use App\Models\LibreriaHabilidad;
use App\Models\LibreriaIdioma;

class CapacidadesClase
{
    // Agregar habilidad al postulante
    public function agregarHabilidad($postulante_id, $habilidad)
    {
        // Busca o crea la habilidad en la librería
        $libreria = LibreriaHabilidad::firstOrCreate(['habilidad' => $habilidad]);
        // Asocia la habilidad al postulante
        return Habilidad::create([
            'libreria_habilidades_id' => $libreria->id,
            'postulante_id' => $postulante_id,
        ]);
    }

    // Listar habilidades de un postulante
    public function listarHabilidades($postulante_id = null)
    {
        if ($postulante_id) {
            return Habilidad::where('postulante_id', $postulante_id)->with('libreria_habilidads')->get();
        }
        return Habilidad::with('libreria_habilidads')->get();
    }
    // Agregar idioma al postulante
    public function agregarIdioma($postulante_id, $idioma, $nivel)
    {
        // Busca o crea el idioma en la librería
        $libreria = LibreriaIdioma::firstOrCreate(['idioma' => $idioma]);
        // Asocia el idioma al postulante
        return Idioma::create([
            'libreria_idiomas_id' => $libreria->id,
            'postulante_id' => $postulante_id,
            'nivel' => $nivel,
        ]);
    }

    // Listar idiomas de un postulante
    public function listarIdiomas($postulante_id = null)
    {
        if ($postulante_id) {
            return Idioma::where('postulante_id', $postulante_id)->with('libreriaidioma')->get();
        }
        return Idioma::with('libreriaidioma')->get();
    }
        // Resumen de capacidades de un postulante
    public function resumen($postulante_id)
    {
        return [
            'habilidades' => $this->listarHabilidades($postulante_id),
            'idiomas' => $this->listarIdiomas($postulante_id),
        ];
    }
}







// class CapacidadesClase extends Usuarioclase
// {
//     public $habilidades = [];
//     public $idiomas = [];

//     public function asignarHabilidades($postulanteId, $libreriaHabilidadId)
//     {
//         $habilidad = Habilidad::create([
//             'postulante_id' => $postulanteId,
//             'libreria_habilidades_id' => $libreriaHabilidadId,
//         ]);

//         // guardamos en el array de la clase
//         $this->habilidades[] = $habilidad;

//         return $habilidad;
//     }



//     public function obtenerTodos()
//     {
//         // Devuelve todas las habilidades e idiomas
//         return [
//             'habilidades' => Habilidad::all(),
//             'idiomas' => Idioma::all(),
//         ];
//     }

//     public function show(int $id)
//     {
//         // Busca una habilidad o idioma por ID
//         $habilidad = Habilidad::find($id);
//         if ($habilidad) return $habilidad;

//         $idioma = Idioma::find($id);
//         if ($idioma) return $idioma;

//         throw new \Exception('No se encontró la capacidad');
//     }

//     public function actualizar(array $datos, string $id)
//     {
//         // Actualiza una habilidad o idioma según el tipo
//         if (isset($datos['tipo']) && $datos['tipo'] === 'habilidad') {
//             $habilidad = Habilidad::findOrFail($id);
//             $habilidad->update($datos);
//             return $habilidad;
//         } elseif (isset($datos['tipo']) && $datos['tipo'] === 'idioma') {
//             $idioma = Idioma::findOrFail($id);
//             $idioma->update($datos);
//             return $idioma;
//         }
//         throw new \Exception('Tipo de capacidad no reconocido');
//     }
//     // ...existing code...
// }


