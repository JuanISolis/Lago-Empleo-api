<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arquitectura\Clases\CapacidadesClase;
use App\Arquitectura\Clases\LibreriahabilidadesClase;
use App\Arquitectura\Clases\LibreriaidiomaClase;
use App\Http\Requests\CrearCapacidadRequest; 
use Illuminate\Routing\Controller;


class CapacidadController extends Controller
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
        $habilidades = $this->capacidades->listarHabilidades();
        return response()->json($habilidades, 200);
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

    public function actualizarHabilidad(Request $request, $habilidadId)
    {
        $habilidad = $this->capacidades->actualizarHabilidad($habilidadId, $request->input('habilidad'));
        return response()->json($habilidad, 200);
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