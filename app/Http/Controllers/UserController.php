<?php

namespace App\Http\Controllers;


use App\Arquitectura\Clases\UserClase;
use App\Http\Requests\CrearUserRequest;
use App\Http\Requests\ActualizarPassRequest;
use Illuminate\Http\Request;
use App\Models\User;

class UserController
{
    protected $user;

    public function __construct(UserClase $user) {
        $this->user = $user;
    }
    
    public function index()
    {
        return response()->json($this->user->obtenerTodos());
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
        
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearUserRequest $request)
    {
        $user = $this->user->crear($request->validated());

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'usuario' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->user->show($id);
        
        return response()->json([
            'usuario' => $user
        ], 201);

    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActualizarPassRequest $request, string $id)
    {
        $user = $this->user->actualizar($request->validated(), $id);
        
        return response()->json([
            'message' => 'Contraseña actualizada correctamente',
            'usuario' => $user
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
