<?php

namespace App\Http\Controllers\libreriaidioma;
use App\Arquitectura\Clases\LibreriahabilidadClase;
use App\Arquitectura\Clases\LibreriaidiomaClase;

use Illuminate\Http\Request;

class habilidadController extends Controller
{
    protected $habilidad;
    protected $idioma;

    public function __construct(
        LibreriahabilidadClase $habilidad,
        LibreriaidiomaClase $idioma
    ) {
        $this->habilidad = $habilidad;
        $this->idioma = $idioma;
    }
    
    
    public function indexhabilidad()
    {
        return response()->json($this->habilidad->obtenerTodos());
    }


    public function indexidioma()
    {
        return response()->json($this->idioma->obtenerTodos());
    }

    
}
