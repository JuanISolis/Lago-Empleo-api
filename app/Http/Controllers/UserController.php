<?php

namespace App\Http\Controllers;

use App\Arquitectura\Clases\UserClase;
use App\Http\Requests\CrearUserRequest;
use App\Http\Requests\ActualizarPassRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
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
        $validated = $request->validated();

        try {
            $userData = $this->user->crear($validated);

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
    // public function update(ActualizarPassRequest $request, $id)
    // {

    // }

    public function actualizarPassword(ActualizarPassRequest $request)
    {
        $validated = $request->validated();
        try {
            $respuesta = $this->user->actualizar($validated);

            return response()->json([
                'data' => $respuesta
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'mensaje' => $e->getMessage()
            ], $e->getCode() ?: 400);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
