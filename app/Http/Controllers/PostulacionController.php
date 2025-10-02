<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use App\Models\Postulacion;
use App\Arquitectura\Clases\PostulacionClase;
use App\Http\Requests\CrearPostulacionRequest;
use App\Http\Requests\ActualizarPostulacionRequest;
use App\Http\Requests\MostrarPostulacionesRequest;

class PostulacionController
{
    protected $postulacion;

    public function __construct(PostulacionClase $postulacion) {
        $this->postulacion = $postulacion;
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearPostulacionRequest $request)
    {
        try {
            $validated = $request->validated();

            // Crear el perfil asociado al usuario autenticado
            $respuesta = $this->postulacion->crear($validated);

            return response()->json([
                'data' => $respuesta
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }

    }

    public function aceptarpostulacion(ActualizarPostulacionRequest $request)
    {
        try {
            $validated = $request->validated();
        
            // Enviar al servicio
            $ActualizarPostulacion = $this->postulacion->actualizar($validated);
        
            return response()->json([
                'data' => $ActualizarPostulacion
            ], 200);
        
        } catch (\Exception $e) {
            \Log::error('Error al actualizar la empresa: ' . $e->getMessage());
            return response()->json([
                'mensaje' => 'Error al actualizar la empresa',
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    public function mostrarpostulaciones(MostrarPostulacionesRequest $request)
    {
        try {
            $validated = $request->validated();

            $postulaciones = $this->postulacion->show($validated);

            return response()->json([
                'data' => $postulaciones
            ], 200);

        }catch (\Exception $e) {
            $code = (int) $e->getCode();
            if ($code < 100 || $code >= 600) {
                $code = 500;
            }
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $code);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
