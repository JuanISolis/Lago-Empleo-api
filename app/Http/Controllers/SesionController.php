<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arquitectura\Clases\SesionClase;
use App\Http\Requests\InicioSesionRequest;
use App\Http\Requests\PassOlvidoRequest;

class SesionController
{
    protected $sesion;

    public function __construct(SesionClase $sesion) {
        $this->sesion = $sesion;
    }

    public function iniciosesion(InicioSesionRequest $request)
    {
        $user = $this->sesion->iniciosesion($request->validated());

        return response()->json([
            'message' => 'Sesion iniciada correctamente'
            , $user
        ], 200);
    }

    public function passolvidada(PassOlvidoRequest $request)
    {
        $user = $this->sesion->passolvidada($request->validated());
        
        return response()->json([
            'message' => 'recuperacion de pass correcta', 
            $user
        ], 200);
    }

    public function destroy(string $id)
    {
        // Implementación pendiente
        return response()->json(['message' => 'Función de eliminación no implementada'], 501);
    }
}
