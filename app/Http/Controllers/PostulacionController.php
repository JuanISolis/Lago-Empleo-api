<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use App\Models\Postulacion;
use App\Arquitectura\Clases\PostulacionClase;
use App\Http\Requests\CrearPostulacionRequest;
use App\Http\Requests\ActualizarUsuarioRequest;

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