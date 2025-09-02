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
    
        // 👉 Procesa la imagen aquí
        if ($request->hasFile('foto_perfil')) {
            $imagen = $request->file('foto_perfil');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaPublica = base_path('../../public/assets');
            $imagen->move($rutaPublica . '/fotos', $nombreImagen);
            $validated['foto_perfil'] = 'assets/fotos/' . $nombreImagen;
        }
    
        // 👉 Pasa solo un array limpio sin archivos
        $usuario = $this->usuario->crear($validated);
    
        return response()->json([
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario
        ], 201);
    }


    

    public function show(string $id)
    {
        $usuario = $this->usuario->show($id);
        
        return response()->json([
            'usuario' => $usuario
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
