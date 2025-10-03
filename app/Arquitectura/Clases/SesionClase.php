<?php

namespace App\Arquitectura\Clases;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;


class SesionClase extends UserClase 
{
    public function iniciosesion($datos)
    {
        $user = User::where('email', $datos['email'])->first();

        if (!$user || $user->estado) {
            throw new \Exception('Usuario no encontrado o inactivo.', 404);
        }

        if (!Hash::check($datos['password'], $user->password)) {
            throw new \Exception('Contraseña incorrecta.', 401);
        }

        $token = $user->createToken('token_de_acceso')->plainTextToken;

        $debeReestablecer = $user->recuperacion;

        if ($debeReestablecer) {
            return [
                'mensaje' => 'Debe reestablecer su contraseña',
                'token' => $token,
                'reset' => true
            ];
        }
    
        return [
            'mensaje' => 'Inicio de sesión exitoso',
            'token' => $token,
            'reset' => false,
            'rol' => $user->rol
        ];
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'mensaje' => 'Sesión cerrada correctamente.'
        ], 200);
    }


    public function passolvidada($datos)
    {
        $user = User::where('email', $datos)->first();

        if (!$user) {
            throw new \Exception('Usuario no encontrado.', 404);
        }

        if ($user->estado) {
            throw new \Exception('Usuario inactivo.', 404);
        }

        $resetPassword = Str::random(10);
        $hashpass = bcrypt($resetPassword);

        $user->update([
            'password' => $hashpass,
            'recuperacion' => true,
        ]);

        // Enviar correo con la contraseña temporal
        Mail::to($user->email)->send(new ResetPasswordMail($resetPassword));

        return true;
    }
public function actualizarpassword($request)
{
    $user = auth()->user(); // usuario autenticado con token

    if (!$user) {
        throw new \Exception('Usuario no autenticado', 401);
    }

    $user->password = bcrypt($request->password);
    $user->recuperacion = false; // ya no necesita reset
    $user->save();

    return response()->json([
        'message' => 'Contraseña actualizada correctamente'
    ], 200);
}





}