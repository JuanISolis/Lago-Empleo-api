<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\Experiencia_laboralClase;
use App\Http\Requests\CrearExperienciaLaboralRequest;
use Illuminate\Http\Request;

class ExperienciaLaboralController extends Controller
{
    protected $experiencia;

    public function __construct(Experiencia_laboralClase $experiencia)
    {
        $this->experiencia = $experiencia;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $experiencias = $this->experiencia->obtenerPorUsuario($user->id);
        return response()->json($experiencias, 200);
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

    public function show(string $id, Request $request)
    {
        $exp = $this->experiencia->showById($id);

        if ($exp->postulante_id !== $request->user()->usuario->postulante->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json(['experiencia' => $exp]);
    }

    public function update(CrearExperienciaLaboralRequest $request, $id)
    {
        $validated = $request->validated();
        $exp = $this->experiencia->actualizarExperiencia($id, $validated);
        return response()->json([
            'message' => 'Experiencia laboral actualizada con éxito',
            'experiencia' => $exp
        ], 200);
    }

    public function destroy(string $id, Request $request)
    {
        $this->experiencia->eliminar($id);
        return response()->json([
            'message' => 'Experiencia laboral eliminada correctamente'
        ]);
    }
}
