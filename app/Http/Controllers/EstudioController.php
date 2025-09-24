<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\EstudioClase;
use App\Http\Requests\CrearEstudioRequest;
use Illuminate\Routing\Controller;

class EstudioController extends Controller
{
    protected $estudio;

    public function __construct(EstudioClase $estudio)
    {
        $this->estudio = $estudio;
    }

    public function index()
    {
        return response()->json($this->estudio->obtenerTodos());
    }

    public function store(CrearEstudioRequest $request)
    {
        try {
            $validated = $request->validated();

            $authUser = auth()->user();
            if (!$authUser) {
                throw new \Exception('Usuario no autenticado', 401);
            }

            $validated['postulante_id'] = $authUser->usuario->id;

            if ($request->hasFile('doc_titulo')) {
                $file = $request->file('doc_titulo');
                $nombreArchivo = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/pdf'), $nombreArchivo);
                $validated['doc_titulo'] = 'assets/pdf/' . $nombreArchivo;
            } else {
                $validated['doc_titulo'] = null;
            }

            $estudio = $this->estudio->crear($validated);

            return response()->json([
                'message' => 'Estudio creado correctamente',
                'estudio' => $estudio
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Error al crear estudio:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al crear estudio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(CrearEstudioRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $validated['id'] = $id; // ⚠️ Necesario para EstudioClase::actualizar

            if ($request->hasFile('doc_titulo')) {
                $file = $request->file('doc_titulo');
                $nombreArchivo = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('assets/pdf'), $nombreArchivo);
                $validated['doc_titulo'] = 'assets/pdf/' . $nombreArchivo;
            }

            $estudio = $this->estudio->actualizar($validated);

            return response()->json([
                'message' => 'Estudio actualizado correctamente',
                'estudio' => $estudio
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error al actualizar estudio:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al actualizar estudio',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
