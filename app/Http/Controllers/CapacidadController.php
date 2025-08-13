<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arquitectura\Clases\CapacidadesClase;
use App\Http\Requests\CrearCapacidadRequest; 
use Illuminate\Routing\Controller;


class CapacidadController extends Controller
{
    protected $capacidades;

    public function __construct()
    {
        // Puedes pasar arrays vacíos porque el constructor de CapacidadesClase los ignora y carga todos
        $this->capacidades = new CapacidadesClase([], []);
    }

    public function index()
    {
        // Devuelve todas las habilidades e idiomas
        return response()->json($this->capacidades->obtenerTodos());
    }

    public function store(Request $request)
    {
        try {
            $capacidad = $this->capacidades->crear($request->all());
            return response()->json($capacidad, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}