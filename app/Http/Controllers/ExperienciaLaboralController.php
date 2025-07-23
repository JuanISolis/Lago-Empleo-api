<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\Experiencia_laboralClase;
use App\Http\Requests\CrearExperienciaLaboralRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExperienciaLaboralController extends Controller
{
    protected $experiencia;

    public function __construct(Experiencia_laboralClase $experiencia)
    {
        $this->experiencia = $experiencia;
    }

    public function index()
    {
        return response()->json($this->experiencia->obtenerTodos());
    }

    public function store(CrearExperienciaLaboralRequest $request)
    {
        $validated = $request->validated();
        $exp = $this->experiencia->crear($validated);

        return response()->json([
            'message' => 'Experiencia laboral creada correctamente',
            'experiencia' => $exp
        ], 201);
    }

    public function show(string $id)
    {
        $exp = $this->experiencia->show($id);

        return response()->json([
            'experiencia' => $exp
        ]);
    }

    public function update(CrearExperienciaLaboralRequest $request, string $id)
    {
        $exp = $this->experiencia->actualizar($request->validated(), $id);

        return response()->json([
            'message' => 'Experiencia laboral actualizada correctamente',
            'experiencia' => $exp
        ]);
    }

    public function destroy(string $id)
    {
        $exp = $this->experiencia->show($id);
        $exp->delete();

        return response()->json([
            'message' => 'Experiencia laboral eliminada correctamente'
        ]);
    }
}