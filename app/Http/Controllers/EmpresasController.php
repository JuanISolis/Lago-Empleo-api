<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\Empresas;
use App\Http\Requests\ActializarEmpresaRequest;
use App\Http\Requests\ActualizarEmpresaRequest;
use App\Http\Requests\ActualizarEmpresasRequest;
use App\Http\Requests\CrearEmpresaRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class EmpresasController extends Controller
{
    protected $empresas;

    public function __construct(Empresas $empresas)
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
        $result = $this->empresas->crear($request->validated());

        return response()->json([
            'message' => 'Empleador y empresa creados correctamente',
            'usuario' => $result['usuario'],
            'empresa' => $result['empresa']
        ], 201);
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
