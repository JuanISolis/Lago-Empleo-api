<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\EstudioClase;
use App\Http\Requests\CrearEstudioRequest;
use App\Models\Postulante;
use Illuminate\Routing\Controller;

class EstudioController extends Controller
{
    protected $estudio;

    public function __construct(EstudioClase $estudio)
    {
        $this->estudio = $estudio;
    }

    // Obtener estudios del usuario autenticado
    public function index()
    {
        $authUser = auth()->user();
        if (!$authUser) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $postulante = Postulante::where('usuario_id', $authUser->id)->first();
        if (!$postulante) {
            return response()->json(['message' => 'No existe un postulante asociado'], 404);
        }

        $estudios = $this->estudio->obtenerPorUsuario($postulante->id);
        return response()->json($estudios);
    }

    // Crear estudio
    public function store(CrearEstudioRequest $request)
    {
        try {
            $validated = $request->validated();

            $authUser = auth()->user();
            if (!$authUser) {
                throw new \Exception('Usuario no autenticado', 401);
            }

            $postulante = Postulante::where('usuario_id', $authUser->id)->first();
            if (!$postulante) {
                throw new \Exception('No existe un postulante asociado a este usuario', 400);
            }

            $validated['postulante_id'] = $postulante->id;

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

    // Actualizar estudio
    public function update(CrearEstudioRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $validated['id'] = $id;

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

    // Eliminar estudio
    public function destroy($id)
    {
        try {
            $authUser = auth()->user();
            if (!$authUser) {
                return response()->json(['message' => 'Usuario no autenticado'], 401);
            }

            $postulante = Postulante::where('usuario_id', $authUser->id)->first();
            if (!$postulante) {
                return response()->json(['message' => 'No existe un postulante asociado'], 404);
            }

            $estudio = $this->estudio->buscar($id);
            if (!$estudio) {
                return response()->json(['message' => 'Estudio no encontrado'], 404);
            }

            if ($estudio->postulante_id !== $postulante->id) {
                return response()->json(['message' => 'No autorizado'], 403);
            }

            $estudio->delete();

            return response()->json(['message' => 'Estudio eliminado correctamente'], 200);

        } catch (\Exception $e) {
            \Log::error('Error al eliminar estudio:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Error al eliminar estudio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Descargar PDF
    public function descargar($id)
    {
        $estudio = \App\Models\Estudio::findOrFail($id);

        if (!$estudio->doc_titulo) {
            return response()->json(['message' => 'No hay certificado disponible'], 404);
        }

        $rutaArchivo = public_path($estudio->doc_titulo);

        if (!file_exists($rutaArchivo)) {
            return response()->json(['message' => 'Archivo no encontrado'], 404);
        }

        $nombreDescarga = basename($rutaArchivo);

        return response()->download($rutaArchivo, $nombreDescarga, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
