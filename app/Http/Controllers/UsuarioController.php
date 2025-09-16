<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\UsuarioClase;
use App\Http\Requests\CrearUsuarioRequest;
use App\Http\Requests\ActualizarUsuarioRequest;
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
        try {
            $validated = $request->validated();

            // Procesar imagen de perfil si existe
            if ($request->hasFile('foto_perfil')) {
                $imagen = $request->file('foto_perfil');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

                $rutaPublica = public_path('assets/fotos');

                if (!file_exists($rutaPublica)) {
                    mkdir($rutaPublica, 0755, true);
                }

                $imagen->move($rutaPublica, $nombreImagen);
                $validated['foto_perfil'] = 'assets/fotos/' . $nombreImagen;
            }

            // Crear el perfil asociado al usuario autenticado
            $respuesta = $this->usuario->crear($validated);

            return response()->json([
                'mensaje' => 'Usuario creado exitosamente.',
                'token' => $respuesta['token'] ?? null,
                'usuario' => [
                    'id' => $respuesta['usuario']->id ?? null,
                    'email' => $respuesta['usuario']->email ?? null,
                    'nombre' => $respuesta['usuario']->nombre ?? null,
                    'apellido' => $respuesta['usuario']->apellido ?? null,
                    'rol' => $respuesta['usuario']->rol ?? null,
                    'foto_perfil' => $respuesta['usuario']->foto_perfil ?? null,
                    // agrega aquí cualquier otro campo que tu frontend necesite
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }

    }


    

    public function show(Request $request)
    {
        $usuario = $request->user();
        $perfil = Usuario::where('user_id', $usuario->id)->first();
        
        return response()->json([
            'usuario' => $usuario,
            'perfil' => $perfil  // Accede al perfil relacionado
        ], 201);

    }


    public function update(CrearUsuarioRequest $request, string $id)
    {
        $usuario = $this->usuario->actualizar($request->validated(), $id);
        
        return response()->json([
            'message' => 'Contraseña actualizada correctamente',
            'usuario' => $usuario
        ], 201);
    }

    public function actualizar(ActualizarUsuarioRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('foto_perfil')) {
                $imagen = $request->file('foto_perfil');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

                $rutaPublica = public_path('assets/fotos');
                if (!file_exists($rutaPublica)) {
                    mkdir($rutaPublica, 0755, true);
                }

                $imagen->move($rutaPublica, $nombreImagen);
                $validated['foto_perfil'] = 'assets/fotos/' . $nombreImagen;
            }

            $perfilActualizado = $this->usuario->actualizar($validated);

            return response()->json([
                'perfil' => $perfilActualizado
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }

    }

    public function verPerfil()
    {
        try {
            $respuesta = $this->usuario->perfil();
        
            return response()->json($respuesta, 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }


}
