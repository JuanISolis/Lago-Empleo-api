<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\Empleador;
use App\Http\Requests\CrearEmpresaRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class EmpleadorController extends Controller
{
    protected $empleador;

    public function __construct(Empleador $empleador)
    {
        $this->empleador = $empleador;
    }

    public function index()
    {
        return response()->json($this->empleador->obtenerTodos());
    }

      public function store(CrearEmpresaRequest $request)
    {
        $result = $this->empleador->crear($request->validated());

        return response()->json([
            'message' => 'Empleador y empresa creados correctamente',
            'usuario' => $result['usuario'],
            'empresa' => $result['empresa']
        ], 201);
    }


    public function show(int $id)
    {
        return $this->empleador->show($id);
    }

    public function update(CrearEmpresaRequest $request, int $id)
    {
        return $this->empleador->actualizar($request->validated(), $id);
    }

   
}
