<?php


namespace App\Http\Controllers;

use App\Arquitectura\Clases\PostulanteClase;
use App\Http\Requests\CrearPostulanteRequest;
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
            'message' => 'Postulante creado correctamente',
            'postulante' => $postulante
        ], 201);
    }

    public function show(string $id)
    {
        $postulante = $this->postulante->show($id);

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
}