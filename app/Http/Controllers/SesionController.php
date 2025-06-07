<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arquitectura\Clases\SesionClase;
use App\Http\Requests\CrearUserRequest;
use App\Http\Requests\ActualizarPassRequest;

class SesionController
{
    protected $sesion;

    public function __construct(SesionClase $sesion) {
        $this->sesion = $sesion;
    }
    public function store(CrearUserRequest $request)
    {
        $user = $this->sesion->crear($request->validated());

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'usuario' => $user
        ], 201);
    }

    public function show(string $id)
    {
        $user = $this->sesion->show($id);

        return response()->json([
            'usuario' => $user
        ], 201);
    }

    public function actualizar(ActualizarPassRequest $request, string $user)
    {
        return response()->json($this->sesion->actualizar($request->validated(), $user));
    }
    public function iniciosesion(Request $request)
    {
        return response()->json($this->sesion->iniciosesion($request->all()));
    }
    public function destroy(string $id)
    {
        // Implementación pendiente
        return response()->json(['message' => 'Función de eliminación no implementada'], 501);
    }
}
