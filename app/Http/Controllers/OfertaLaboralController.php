<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfertaLaboral;
use Illuminate\Routing\Controller;

class OfertaLaboralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'empresa' => 'required|string|max:255',
            'salario' => 'nullable|numeric',
            // Agrega aquí los campos que tenga tu modelo
        ]);

        $oferta = OfertaLaboral::create($validated);
        return response()->json($oferta, 201);
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
