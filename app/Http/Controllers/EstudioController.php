<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudio;
use App\Arquitectura\Clases\EstudioClase;
use App\Arquitectura\Requests\CrearEstudioRequest;
use App\Arquitectura\Interfaces\MercadoLaboral;


class EstudioController
{
    /**
     * Display a listing of the resource.
     */

    protected $estudio;

    // Inyección de dependencias
    public function __construct(MercadoLaboral $estudio)
    {
        $this->estudio = $estudio;
    }

    public function index()
    {
        return response()->json($this->estudio->obtenerTodos());
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
    public function store(CrearEstudioRequest $request)
    {
        $datos = $request->all();
        return response()->json($this->estudio->crear($datos));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($this->estudio->show($id));

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
    public function update(CrearEstudioRequest $request, string $id)
    {
        $datos = $request->all();
        $datos['id'] = $id;
        return response()->json($this->estudio->actualizar($datos));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
