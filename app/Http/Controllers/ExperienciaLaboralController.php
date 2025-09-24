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

    public function update(CrearExperienciaLaboralRequest $request)
    {
        try {
        // ✅ Obtener los datos validados desde el FormRequest
        $validated = $request->validated();

        \Log::info('📥 Datos validados recibidos en backend:', $validated);

        // ✅ Delegar la lógica de actualización al servicio
        $experienciaActualizada = $this->experiencia->actualizar($validated);

        return response()->json([
            'mensaje' => 'Experiencia laboral actualizada con éxito',
            'experiencia' => $experienciaActualizada
        ], 200);

        } catch (\Exception $e) {
            \Log::error('Error al actualizar experiencia laboral: ' . $e->getMessage());

            return response()->json([
                'mensaje' => 'Error al actualizar experiencia laboral',
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
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
