<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arquitectura\Clases\CapacidadesClase;
use App\Arquitectura\Clases\LibreriahabilidadesClase;
use App\Arquitectura\Clases\LibreriaidiomaClase;
use App\Http\Requests\CrearCapacidadRequest; 
use App\Http\Requests\ActualizarHabilidadRequest;
use Illuminate\Routing\Controller;


class  CapacidadController extends Controller
{
    protected $capacidades;

    public function __construct()
    {
        $this->capacidades = new CapacidadesClase();
    }

    public function agregarHabilidad(Request $request)
    {
        $habilidad = $this->capacidades->agregarHabilidad($request->input('habilidad'));
        return response()->json($habilidad, 201);
    }

    public function listarHabilidades()
    {
        try {
            $habilidades = $this->capacidades->listarHabilidades();
            return response()->json($habilidades);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    

    public function agregarIdioma(Request $request)
    {
        $datos = $request->only(['idioma', 'nivel']);
        return $this->capacidades->agregarIdioma($datos, 201);
    }

    public function listarIdiomas()
    {
        try {
            $idiomas = $this->capacidades->listarIdiomas();
            return response()->json($idiomas);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function actualizarHabilidad(ActualizarHabilidadRequest $request, $habilidadId)
    {
        try {
        $datos = $request->validated();

        \Log::info('📥 Datos recibidos para actualizar habilidad:', $datos);

        $habilidadActualizada = $this->capacidades->actualizarHabilidad($datos, $habilidadId);

        // Eliminar el campo habilidad_id después de la actualización
        unset($habilidadActualizada['libreria_habilidades_id']);

        return response()->json([
            'mensaje' => 'Habilidad actualizada con éxito',
            'habilidad' => $habilidadActualizada
        ], 200);
    } catch (\Exception $e) {
        \Log::error('Error al actualizar la habilidad: ' . $e->getMessage());
        return response()->json([
            'mensaje' => 'Error al actualizar la habilidad',
            'error' => $e->getMessage()
        ], $e->getCode() ?: 400);
    }
    }

    public function eliminarHabilidad($habilidadId)
    {
        $resultado = $this->capacidades->eliminarHabilidad($habilidadId);
        return response()->json($resultado, 200);
    }

    // public function index()
    // {
    //     // Devuelve todas las habilidades e idiomas
    //     return response()->json($this->capacidades->obtenerTodos());
    // }

    // public function store(CrearCapacidadRequest $request)
    // {
    //     try {
    //         $capacidad = $this->capacidades->crear($request->all());
    //         return response()->json($capacidad, 201);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }
}