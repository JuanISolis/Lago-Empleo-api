<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\OfertaLaboralClase;
use Illuminate\Http\Request;
use App\Models\OfertaLaboral;
use App\Http\Requests\CrearOfertaLaboralRequest;
use App\Http\Requests\ActualizarOfertaRequest;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class OfertaLaboralController extends Controller
{
    protected $ofertas;

    public function __construct(OfertaLaboralClase $ofertas) {
        $this->ofertas = $ofertas;
    }

   
    public function index()
    {
        $ofertas = OfertaLaboral::all();
        return response()->json($ofertas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearOfertaLaboralRequest $request)
    {
        $validated = $request->validated();

        try {
            $userData = $this->ofertas->crear($validated);

            return response()->json([
                'usuario' => $userData
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    /**
     * Display the specified resource.
    */

    public function show(string $id)
    {
        $oferta = OfertaLaboral::find($id);

        if (!$oferta) {
            return response()->json(['error' => 'Oferta no encontrada'], 404);
        }

        // Verificar si la fecha de inicio ya pasó o es hoy
        $fechaInicio = Carbon::parse($oferta->fecha_inicio);
        $hoy = Carbon::today();

        if ($fechaInicio->lte($hoy)) {
            return response()->json(['error' => 'La oferta ya no está disponible'], 404);
        }

        return response()->json($oferta);
    }

    public function mostrarOfertasempleador(Request $request)
    {
        try {
            $ofertas = $this->ofertas->show($request);
            // $ofertas = $servicio->show(); 
        
            return response()->json([
                'mensaje' => 'Ofertas laborales recuperadas correctamente.',
                'ofertas' => $ofertas
            ], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $oferta = OfertaLaboral::find($id);
        if (!$oferta) {
            return response()->json(['error' => 'Oferta no encontrada'], 404);
        }

        $validated = $request->validate([
            'titulo_ofertalaboral' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'empresa' => 'sometimes|required|string|max:255',
            'pago' => 'nullable|numeric',
            // Agrega aquí los campos que tenga tu modelo
        ]);

        $oferta->update($validated);
        return response()->json($oferta);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $oferta = OfertaLaboral::find($id);
        if (!$oferta) {
            return response()->json(['error' => 'Oferta no encontrada'], 404);
        }
        $oferta->delete();
        return response()->json(['message' => 'Oferta eliminada correctamente']);
    }

    public function actualizaroferta(ActualizarOfertaRequest $request)
    {
        try {
            $datos = $request->all();
        
            \Log::info('📥 Datos recibidos en backend:', $datos);
        
            // Filtrar datos vacíos
            $validated = array_filter($datos, function ($valor) {
                return $valor !== null && $valor !== '';
            });
        
            \Log::info('📦 Datos que van a actualizarse en la BD (controlador):', $validated);
        
            // Enviar al servicio
            $ActualizarOferta = $this->ofertas->actualizar($validated);
        
            return response()->json([
                'mensaje' => 'Empresa actualizado con éxito',
                'Empresa' => $ActualizarOferta
            ], 200);
        
        } catch (\Exception $e) {
            \Log::error('Error al actualizar la empresa: ' . $e->getMessage());
            return response()->json([
                'mensaje' => 'Error al actualizar la empresa',
                'error' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }

    public function buscarOfertas(Request $request)
    {
        $query = OfertaLaboral::query();

        // Filtrar por descripción utilizando el campo 'titulo_ofertalaboral'
        if ($request->filled('descripcion')) {
            $query->where('titulo_ofertalaboral', 'like', '%' . $request->input('descripcion') . '%');
        }

        // Filtrar por ubicación utilizando el campo 'ubicacion'
        if ($request->filled('ubicacion')) {
            $query->where('ubicacion', 'like', '%' . $request->input('ubicacion') . '%');
        }

        // Obtener resultados
        $ofertas = $query->get();

        return response()->json([
            'mensaje' => 'Búsqueda realizada con éxito.',
            'ofertas' => $ofertas
        ], 200);
    }
}
