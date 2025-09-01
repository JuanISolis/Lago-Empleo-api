<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Arquitectura\Clases\SesionClase;
use App\Http\Requests\InicioSesionRequest;
use App\Http\Requests\PassOlvidoRequest;
use Illuminate\Routing\Controller;

class SesionController extends Controller
{
    protected $sesion;

    public function __construct(SesionClase $sesion) {
        $this->sesion = $sesion;
    }

    public function iniciosesion(InicioSesionRequest $request)
    {
        $user = $this->sesion->iniciosesion($request->validated());

        if (!$user) {
            \Log::error('Login fallido: usuario no encontrado o credenciales incorrectas', $request->validated());
            return response()->json([
                "message" => "Usuario o contraseña incorrectos"
            ], 401);
        }

        // Verifica si el campo rol existe
        if (!isset($user->rol)) {
            \Log::error('El campo rol no existe en el modelo User', ['user' => $user]);
            return response()->json([
                "message" => "El usuario no tiene rol asignado"
            ], 500);
        }

        // Genera el token (si usas Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "email" => $user->email,
            "rol" => $user->rol,
            "token" => $token,
            "message" => "Sesión iniciada correctamente"
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
