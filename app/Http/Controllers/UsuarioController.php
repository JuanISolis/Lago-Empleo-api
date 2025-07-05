<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\UsuarioClase;
use App\Http\Requests\CrearUsuarioRequest;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Routing\Controller;

class UsuarioController extends Controller
{
    protected $usuario;

    public function __construct(UsuarioClase $usuario) {
        $this->usuario = $usuario;
    }
    
    
    public function index()
    {
        return response()->json($this->usuario->obtenerTodos());
    }


    public function store(CrearUsuarioRequest $request)
    {
        $validated = $request->validated(); 
        
        $usuario = $this->usuario->crear($validated);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario
        ], 201);
    }

    

    public function show(string $id)
    {
        $user = $this->user->show($id);
        
        return response()->json([
            'usuario' => $user
        ], 201);

    }


    public function update(UsuarioRequest $request, string $id)
    {
        $user = $this->user->actualizar($request->validated(), $id);
        
        return response()->json([
            'message' => 'Contraseña actualizada correctamente',
            'usuario' => $user
        ], 201);
    }
}
