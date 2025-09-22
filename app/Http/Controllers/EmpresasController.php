<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\EmpresasClase;
use App\Http\Requests\ActializarEmpresaRequest;
use App\Http\Requests\ActualizarEmpresaRequest;
use App\Http\Requests\ActualizarEmpresasRequest;
use App\Http\Requests\CrearEmpresaRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class EmpresasController extends Controller
{
    protected $empresas;

    public function __construct(EmpresasClase $empresas)
    {
        $this->empresas = $empresas;
    }

    public function index(Request $request)
    
    {
        $usuario = $request->user();
        return response()->json($this->empresas->obtenerTodos($usuario));
        
    }

      public function store(CrearEmpresaRequest $request)
    {
        try{

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

            $result = $this->empresas->crear($validated);


            return response()->json([
                'message' => 'Empleador y empresa creados correctamente',
                'empresa' => $result
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }

    }


    public function show(int $id)
    {
        return $this->empresas->show($id);
    }

    public function update(ActualizarEmpresasRequest $request, int $id)
    {
        return $this->empresas->actualizar($request->validated(), $id);
    }

   
}
