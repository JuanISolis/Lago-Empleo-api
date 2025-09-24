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

    // Listar SOLO las experiencias del usuario autenticado
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $experienciasLaborales = $this->experiencia->obtenerPorUsuario($user->id);

            return response()->json($experienciasLaborales, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    // Crear nueva experiencia y asociarla al usuario autenticado
    public function store(CrearExperienciaLaboralRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        $exp = $this->experiencia->crear($validated);

        return response()->json([
            'message' => 'Experiencia laboral creada correctamente',
            'experiencia' => $exp
        ], 201);
    }

    public function show(string $id, Request $request)
    {
        $exp = $this->experiencia->show($id);

        // Validar que la experiencia sea del usuario autenticado
        if ($exp->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json([
            'experiencia' => $exp
        ]);
    }

    public function update(CrearExperienciaLaboralRequest $request, string $id)
    {
        $exp = $this->experiencia->show($id);

        if ($exp->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $exp = $this->experiencia->actualizar($request->validated(), $id);

        return response()->json([
            'message' => 'Experiencia laboral actualizada correctamente',
            'experiencia' => $exp
        ]);
    }

    public function destroy(string $id, Request $request)
    {
        $exp = $this->experiencia->show($id);

        if ($exp->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $exp->delete();

        return response()->json([
            'message' => 'Experiencia laboral eliminada correctamente'
        ]);
    }
}
