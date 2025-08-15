<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SesionClase extends UserClase implements MercadoLaboral
{
    public function iniciosesion($datos)
    {
        $user = User::where('email', $datos['email'])->first();

        if ($user->recuperacion) {

            if (!$user || !Hash::check($datos['password'], $user->password)) {
                return response()->json(['message' => 'Credenciales incorrectas'], 401);
            }else {
                return response()->json([
                    'message' => 'El usuario ha solicitado cambio de contraseña',
                    'id' => $user->id
                ], 401);
            }
        }

        if (!$user || !Hash::check($datos['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        return $user;
        
    }

    public function passolvidada($datos)
    {
        $user = User::where('email', $datos)->first();

        if (!$user){
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $temppassword = Str::random(10);
        $hashpass = bcrypt($temppassword);
        
        $user->update([
            'password'=> $hashpass,
            'recuperacion' => true,
        ]);

        return response()->json([
            'message' => 'Se confirma solicitud de recuperacion de contraseña',
            'contraseña' => $temppassword,
            'user' => [
                'id' => $user->id,
                'recuperacion' => $user->recuperacion
            ] 
        ], 200);
    }
}