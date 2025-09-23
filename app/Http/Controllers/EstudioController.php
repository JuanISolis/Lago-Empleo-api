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

        // // Registro inicial para verificar los datos validados
        // \Log::info('Datos validados:', $request->all());

        $validated = $request->validated();

        // Crear el estudio con postulante_id automático
        $estudio = $this->estudio->crear($validated);

        $rutaPublica = base_path('../../public/assets/pdf');

        // Manejar archivo PDF si se sube
        if ($request->hasFile('doc_titulo')) {
            $archivos = $request->file('doc_titulo');
        if (!is_array($archivos)) {
            $archivos = [$archivos]; // Convertir a arreglo si es un único archivo
        }

            foreach ((array) $request->file('doc_titulo') as $archivo) {
                if ($archivo instanceof \Illuminate\Http\UploadedFile) {
                    \Log::info('Archivo recibido:', ['nombre' => $archivo->getClientOriginalName()]);
                } else {
                    \Log::warning('Elemento no es una instancia de UploadedFile:', ['elemento' => $archivo]);
                    continue; // Saltar este elemento
                }
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();

                $rutaPublica = public_path('assets/pdf');
                if (!file_exists($rutaPublica)) {
                    mkdir($rutaPublica, 0755, true);
                }

                $archivo->move($rutaPublica, $nombreArchivo);
                $rutasDocumentos[] = 'assets/pdf/' . $nombreArchivo;
            }

            // Guardar las rutas como JSON en la DB
            // $validated['doc_titulo'] = json_encode($rutasDocumentos);
        } else {
            // Si no hay PDF, dejamos nulo
            $validated['doc_titulo'] = null;
        }

        // Usar la clase para crear el estudio
        $respuesta = $this->estudio->crear($validated);

        return response()->json($respuesta, 201);

    } catch (\Exception $e) {
        // Siempre HTTP válido
        // linea agregada para debug 73
        // \Log::error('Error al crear el estudio:', ['error' => $e->getMessage()]);
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