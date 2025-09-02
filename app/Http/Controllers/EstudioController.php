<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\EstudioClase;
use App\Http\Requests\CrearEstudioRequest;
use Illuminate\Http\Request;
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
        $validated = $request->validated();
        $estudio = $this->estudio->crear($validated);

        return response()->json([
            'message' => 'Estudio creado correctamente',
            'estudio' => $estudio
        ], 201);
    }

    public function show(string $id)
    {
        $estudio = $this->estudio->show($id);

        return response()->json([
            'estudio' => $estudio
        ], 200);
    }

    public function update(CrearEstudioRequest $request, string $id)
    {
        $estudio = $this->estudio->actualizar($request->validated(), $id);

        return response()->json([
            'message' => 'Estudio actualizado correctamente',
            'estudio' => $estudio
        ], 200);
    }
}