<?php

namespace App\Arquitectura\Clases;

use App\Arquitectura\Interfaces\MercadoLaboral;
use App\Models\Usuario;

class UsuarioClase implements MercadoLaboral{
    
    public function obtenerTodos()
    {
        return Usuario::all();
    }

    public function crear(array $datos)
    {

        $rutaPublica = base_path('../../public/assets');

        if ($datos->hasFile('foto_perfil')) {
            $imagen = $datos->file('foto_perfil');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move($rutaPublica . '/fotoperfil', $nombreImagen);
            $datos['foto_perfil'] = 'assets/fotoperfil/' . $nombreImagen; 
        }

        return Usuario::create($datos);
    }

    public function show(int $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {

            return response()->json(['message' => 'Usuario no encontrado'], 404);

        }

        return $usuario;
    }

    public function actualizar(array $datos, string $id)
    {
        $usuario = User::find($id);
        
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $rutaPublica = base_path('../public/assets');

        if ($datos->hasFile('imagen')) {
            $imagen = $datos->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move($rutaPublica . '/imagen', $nombreImagen);
            $datos['imagen'] = 'assets/imagen/' . $nombreImagen; // esta ruta se guarda en la BD
        }


        $usuario->update($datos);

        return response()->json($usuario, 201);
    }

}