<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\EmpresasClase;
use App\Models\InformacionEmpresa;
use App\Http\Requests\ActualizarEmpresaRequest;
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
        
        $empresa = InformacionEmpresa::all();
        return response()->json($empresa);
        
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

    public function actualizarempresa(ActualizarEmpresaRequest $request)
    {
        try {
            // 💡 Recoger todos los campos como vienen
            $datos = $request->all();
        
            \Log::info('📥 Datos recibidos en backend:', $datos);
        
            // Filtrar datos vacíos
            $validated = array_filter($datos, function ($valor) {
                return $valor !== null && $valor !== '';
            });
        
            // Procesar imagen si fue enviada
            if ($request->hasFile('imagen_empresa')) {
                $imagen = $request->file('imagen_empresa');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
                $rutaPublica = public_path('assets/fotos');
                if (!file_exists($rutaPublica)) {
                    mkdir($rutaPublica, 0755, true);
                }
            
                $imagen->move($rutaPublica, $nombreImagen);
                $validated['imagen_empresa'] = 'assets/fotos/' . $nombreImagen;
            }
        
            \Log::info('📦 Datos que van a actualizarse en la BD (controlador):', $validated);
        
            // Enviar al servicio
            $ActualizarEmpresa = $this->empresas->actualizar($validated);
        
            return response()->json([
                'mensaje' => 'Empresa actualizado con éxito',
                'Empresa' => $ActualizarEmpresa
            ], 200);
        
        } catch (\Exception $e) {
            \Log::error('Error al actualizar la empresa: ' . $e->getMessage());
            return response()->json([
                'mensaje' => 'Error al actualizar la empresa',
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    public function mostrarEmpresa(Request $request)
    {
        try {
            $empresas = $this->empresas->show($request);
            // $ofertas = $servicio->show(); 
        
            return response()->json([
                'mensaje' => 'Ofertas laborales recuperadas correctamente.',
                'ofertas' => $empresas
            ], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
   
}
