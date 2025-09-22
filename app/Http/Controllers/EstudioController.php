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
        try {
            $validated = $request->validated();
            // Procesar múltiples PDFs obligatorios
            if ($request->hasFile('doc_titulo')) {
                foreach ($request->file('doc_titulo') as $archivo) {
                    $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();

                    $rutaPublica = public_path('assets/pdf');
                    if (!file_exists($rutaPublica)) {
                        mkdir($rutaPublica, 0755, true);
                    }

                    $archivo->move($rutaPublica, $nombreArchivo);

                    $rutasDocumentos[] = 'assets/pdf/' . $nombreArchivo;
                }
            } else {
                throw new \Exception('El archivo PDF es obligatorio.', 400);
            }

            // Guardar las rutas como JSON en la DB
            $validated['doc_titulo'] = json_encode($rutasDocumentos);

            // Usar la clase para crear el estudio
            $respuesta = $this->estudio->crear($validated);

            return response()->json($respuesta, 201);

        }   
        catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
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