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

    // 📌 Listar todas las experiencias del usuario autenticado
    public function index(Request $request)
    {
        $user = $request->user();
        $experiencias = $this->experiencia->obtenerPorUsuario($user->id);

        return response()->json([
            'data' => $experiencias
        ], 200);
    }

    // 📌 Crear nueva experiencia laboral
    public function store(CrearExperienciaLaboralRequest $request)
    {
        $validated = $request->validated();
        $exp = $this->experiencia->crear($validated);

        return response()->json([
            'message' => 'Experiencia laboral creada correctamente',
            'data'    => $exp
        ], 201);
    }

    // 📌 Mostrar detalle de una experiencia
    public function show(string $id, Request $request)
    {
        $exp = $this->experiencia->showById($id);

        if ($exp->postulante_id !== $request->user()->usuario->postulante->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json([
            'data' => $exp
        ], 200);
    }

    // 📌 Actualizar una experiencia laboral
    public function update(CrearExperienciaLaboralRequest $request, $id)
    {
        $validated = $request->validated();
        $exp = $this->experiencia->actualizarExperiencia($id, $validated);

        return response()->json([
            'message' => 'Experiencia laboral actualizada con éxito',
            'data'    => $exp
        ], 200);
    }

    // 📌 Eliminar una experiencia laboral
    public function destroy(string $id, Request $request)
    {
        $this->experiencia->eliminar($id);

        return response()->json([
            'message' => 'Experiencia laboral eliminada correctamente'
        ], 200);
    }
}
