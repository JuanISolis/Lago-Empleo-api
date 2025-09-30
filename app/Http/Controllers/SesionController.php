<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arquitectura\Clases\SesionClase;
use App\Http\Requests\InicioSesionRequest;
use App\Http\Requests\PassOlvidoRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class SesionController extends Controller
{
    protected $sesion;

    public function __construct(SesionClase $sesion) {
        $this->sesion = $sesion;
    }

    public function iniciosesion(InicioSesionRequest $request)
    {
        $validated = $request->validated();

        try {
            $loginData = $this->sesion->iniciosesion($validated);

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'data' => $loginData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }

    }
    
    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada correctamente.'
        ], 200);
    }

    public function passolvidada(PassOlvidoRequest $request)
    {
        
        $datos = $request->all();
    
        Log::info('📥 Datos recibidos en backend:', $datos);

        $validated = $request->validated();

        try {
            $resetPassword = $this->sesion->passolvidada($validated);

            return response()->json([
                'login' => $resetPassword
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }


    public function destroy(string $id)
    {
        // Implementación pendiente
        return response()->json(['message' => 'Función de eliminación no implementada'], 501);
    }
}

