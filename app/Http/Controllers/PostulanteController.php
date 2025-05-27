<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postulante;

class PostulanteController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Postulante::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $request->validate([
            'ci' => 'required|unique:postulantes',
            'foto_perfil' => 'required|file|mimes:jpg,jpeg,png',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required|string',
            'contacto' => 'required|integer',
            'direccion' => 'nullable|integer',
            'profesion' => 'nullable|integer',
            'descripcion' => 'nullable|text',
            'discapacidad' => 'required|boolean',
            'tipo_discapacidad' => 'nullable|string',
            'porcent_discapacidad' => 'nullable|integer',
        ]);

        $imagenPath = null;

        if ($request->hasFile('foto_perfil')) {
            $imagen = $request->file('foto_perfil');
            $imagenName = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('assets/imagen'), $imagenName);
            $imagenPath = 'assets/imagen/' . $imagenName;
        }

        $postulante = Postulante::create([
            'ci'=> $request->ci,
            'foto_perfil' => $imagenPath,
            'nombre'=> $request->nombre,
            'apellido'=> $request->apellido,
            'fecha_nacimiento'=> $request->fecha_nacimiento,
            'sexo'=> $request->sexo,
            'contacto'=> $request->contacto,
            'direccion'=> $request->direccion,
            'profesion'=> $request->profesion,
            'descripcion'=> $request->descripcion,
            'discapacidad'=> $request->discapacidad,
            'tipo_discapacidad'=> $request->tipo_discapacidad,
            'porcent_discapacidad'=> $request->porcent_discapacidad,
        ]);

        return response()->json($postulante, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $postulante = Postulante::find($id);
        if (!$postulante) {
            return response()->json(['message' => 'Postulante no encontrado'], 404);
        }
        return response()->json($postulante);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
