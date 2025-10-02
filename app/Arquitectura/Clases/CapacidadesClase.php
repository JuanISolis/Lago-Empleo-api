<?php

namespace App\Arquitectura\Clases;
use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\Idioma;
use App\Models\Habilidad;
use App\Models\postulante;
use App\Models\LibreriaHabilidad;
use App\Models\LibreriaIdioma;

class CapacidadesClase extends PostulanteClase
{
    // Agregar habilidad al postulante
   public function agregarHabilidad(string $habilidadNombre)
    {
        $authUser = auth()->user();
    
        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }
    
        $postulanteId = $authUser->usuario->postulante->id;
    
        try {
            // 1. Busca o crea la habilidad en la librería
            $libreriaHabilidad = LibreriaHabilidad::firstOrCreate([
                'habilidad' => $habilidadNombre
            ]);
        
            // 2. Inserta en la tabla habilidades la relación
            return Habilidad::create([
                'postulante_id' => $postulanteId,
                'libreria_habilidades_id' => $libreriaHabilidad->id,
            ]);
        
        } catch (\Exception $e) {
            throw new \Exception('Error al agregar la habilidad: ' . $e->getMessage());
        }
    }

    // Listar habilidades de un postulante
    public function listarHabilidades()
    {
        $authUser = auth()->user();

        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        $postulanteId = $authUser->usuario->postulante->id;

        return Habilidad::where('postulante_id', $postulanteId)->with('libreria_habilidad')->get();
    }
    // Agregar idioma al postulante
    public function agregarIdioma(array $datos)
    {
        
        $authUser = auth()->user();
    
        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }
    
        $postulanteId = $authUser->usuario->postulante->id;
    
        try {
            // 1. Busca o crea la idioma en la librería
            $libreriaIdioma = LibreriaIdioma::firstOrCreate([
                'idioma' => $datos['idioma'] 
            ]);
        
            // 2. Inserta en la tabla idioma la relación
            return Idioma::create([
                'libreria_idiomas_id' => $libreriaIdioma->id,
                'postulante_id' => $postulanteId,
                'nivel' => $datos['nivel'],
            ]);
        
        } catch (\Exception $e) {
            throw new \Exception('Error al agregar la idioma: ' . $e->getMessage());
        }
    }
    // Listar idiomas de un postulante
    public function listarIdiomas()
    {
        $authUser = auth()->user();

        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        $postulanteId = $authUser->usuario->postulante->id;

        return Idioma::where('postulante_id', $postulanteId)->with('libreria_idioma')->get();
    }

    // Actualizar una habilidad del postulante
    public function actualizarHabilidad($habilidadId, $nuevaHabilidad)
    {
            $authUser = auth()->user();

        if (!$authUser) {
            throw new \Exception('Usuario no autenticado', 401);
        }

        $usuario = $authUser->usuario;

        if (!$usuario) {
            throw new \Exception('No se encontró el perfil de usuario.', 404);
        }

        $habilidad = $usuario->habilidades()->where('id', $habilidadId)->first();

        if (!$habilidad) {
            throw new \Exception('Habilidad no encontrada o no pertenece al usuario.', 404);
        }

        \Log::info('📦 Datos que van a actualizarse en la BD (servicio - habilidad):', $datos);

        // Actualizar la habilidad
        $habilidad->update($datos);

        // Eliminar el campo habilidad_id después de la actualización
        unset($datos['habilidad_id']);

        \Log::info('📦 Datos actualizados (habilidad):', $habilidad->toArray());

        return $habilidad;
    }

    // Eliminar una habilidad del postulante
    public function eliminarHabilidad($habilidadId)
    {
        $authUser = auth()->user();

        if (!$authUser || !$authUser->usuario || !$authUser->usuario->postulante) {
            throw new \Exception('El usuario no tiene un perfil de postulante.');
        }

        $postulanteId = $authUser->usuario->postulante->id;

        // Buscar la habilidad asociada al postulante
        $habilidad = Habilidad::where('id', $habilidadId)
            ->where('postulante_id', $postulanteId)
            ->firstOrFail();

        // Eliminar la habilidad
        $habilidad->delete();

        return ['message' => 'Habilidad eliminada correctamente'];
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


