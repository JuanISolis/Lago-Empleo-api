<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\OfertaLaboralClase;
use Illuminate\Http\Request;
use App\Models\OfertaLaboral;
use App\Http\Requests\CrearOfertaLaboralRequest;
use Illuminate\Routing\Controller;

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
        return response()->json($oferta);
    }

    public function mostrarOfertasempleador(Request $request, OfertaLaboralClase $servicio)
    {
        try {
            $ofertas = $servicio->show(); // Llama al método desde el servicio, no desde el request
        
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
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'empresa' => 'sometimes|required|string|max:255',
            'salario' => 'nullable|numeric',
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
}
