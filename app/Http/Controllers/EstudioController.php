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
        

        $rutaPublica = base_path('../../public/assets/pdf');

        if ($datos->hasFile('doc_titulo')) {
            $archivo = $datos->file('doc_titulo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move($rutaPublica('assets/pdf'), $nombreArchivo);
            $validated['doc_titulo'] = 'assets/pdf/' . $nombreArchivo;
        }

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

        $rutaPublica = base_path('../../public/assets/pdf');

        if ($datos->hasFile('doc_titulo')) {
            $archivo = $datos->file('doc_titulo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move($rutaPublica('assets/pdf'), $nombreArchivo);
            $validated['doc_titulo'] = 'assets/pdf/' . $nombreArchivo;
        }

        return response()->json([
            'message' => 'Estudio actualizado correctamente',
            'estudio' => $estudio
        ], 200);
    }
}