<?php

namespace App\Http\Controllers;

use App\Models\Postulante;
use App\Models\Estudio;
use App\Models\Habilidad;
use App\Models\Idioma;
use App\Models\ExperienciaLaboral;

use App\Arquitectura\Clases\DatosPostulanteClase;
use Illuminate\Http\Request;

class DatosPostulanteController extends Controller
{

    public function show(string $id)
    {

        $postulante = Postulante::with('habilidad','idioma','estudio','experiencialaboral')->findOrFail($id);
        
        return response()->json([
            'postulante' => $postulante
        ], 200);
    }
}