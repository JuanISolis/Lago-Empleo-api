<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserClase implements MercadoLaboral{
    
    public function obtenerTodos()
    {
        return User::all();
    }

    public function crear(array $datos)
    {
        $datos['password'] = Hash::make($datos['password']);
        unset($datos['repeatpassword']);

        return User::create($datos);
    }

    public function show(int $id)
    {
        $user = User::find($id);

        if (!$user) {

            return response()->json(['message' => 'Usuario no encontrado'], 404);

        }

        return $user;

    }

    public function actualizar(array $datos)
    {
        return User::create($datos);
    }

}