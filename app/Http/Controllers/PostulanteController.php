<?php


namespace App\Http\Controllers;

use App\Arquitectura\Clases\PostulanteClase;
use App\Http\Requests\CrearPostulanteRequest;
use App\Http\Requests\ActualizarPostulanteRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostulanteController extends Controller
{
    protected $postulante;

    public function __construct(PostulanteClase $postulante) {
        $this->postulante = $postulante;
    }

    public function index()
    {
        return response()->json($this->postulante->obtenerTodos());
    }

    public function store(CrearPostulanteRequest $request)
    {
        $postulante = $this->postulante->crear($request->validated());

        return response()->json([
            // 'message' => 'Postulante creado correctamente',
            'postulante' => $postulante
        ], 201);
    }

    public function show(string $id)
    {
        $postulante = Postulante::with('usuario.user')->findOrFail($id);
    
        return response()->json([
            'postulante' => $postulante
        ], 200);
    }


    public function update(CrearPostulanteRequest $request, string $id)
    {
        $postulante = $this->postulante->actualizar($request->validated(), $id);

        return response()->json([
            'message' => 'Postulante actualizado correctamente',
            'postulante' => $postulante
        ], 200);
    }

    public function destroy(string $id)
    {
        // Implementar si es necesario
    }

    public function infopostulante()
    {
        // Delegamos la lógica al servicio
        $postulante = $this->postulante->show();
        

        return response()->json([
            'postulante' => $postulante
        ], 200);
    }

    public function actualizarpostulante(ActualizarPostulanteRequest $request)
    {
        try {
            // ✅ Obtener los datos validados desde el FormRequest
            $validated = $request->validated();

            \Log::info('📥 Datos validados recibidos en backend:', $validated);

            // ✅ Enviar los datos validados al servicio
            $perfilActualizado = $this->postulante->actualizar($validated);

            return response()->json([
                'mensaje' => 'Perfil actualizado con éxito',
                'perfil' => $perfilActualizado
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error al actualizar perfil: ' . $e->getMessage());

            return response()->json([
                'mensaje' => 'Error al actualizar perfil',
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }


}