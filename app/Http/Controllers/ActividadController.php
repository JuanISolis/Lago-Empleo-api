<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;


class ActividadController
{

    public function notificaciones(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        // Trae TODAS las notificaciones ordenadas por fecha
        $notificaciones = $user->notifications()->latest()->get();

        // Mapea las notificaciones para devolver solo la info útil
        $formateadas = $notificaciones->map(function ($noti) {
            return [
                'id' => $noti->id,
                'tipo' => $noti->data['tipo'] ?? null,
                'descripcion' => $noti->data['descripcion'] ?? null,
                'rol' => $noti->data['rol'] ?? null,
                'oferta_id' => $noti->data['oferta_id'] ?? null,
                'read_at' => $noti->read_at,
                'created_at' => $noti->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'notificaciones' => $formateadas,
        ]);
    }

}
