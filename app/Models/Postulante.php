<?php

namespace App\Models;
use App\Models\ExperienciaLaboral;
use App\Models\Idioma;
use App\Models\Estudio;
use App\Models\Habilidad;
use App\Models\Postulacion;
use App\Models\Usuario;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    //
     protected $fillable = [
        'usuario_id',
        'profesion',
        'descripcion',
        'discapacidad',
        'tipo_discapacidad',
        'porcent_discapacidad',
    ];

    public function experiencialaboral()
    {
        return $this->hasMany(ExperienciaLaboral::class);
    }
    public function idioma()
    {
        return $this->hasMany(Idioma::class);
    }
    public function estudio()
    {
        return $this->hasMany(Estudio::class);
    }
    public function habilidad()
    {
        return $this->hasMany(Habilidad::class);
    }
    public function postulacion()
    {
        return $this->hasMany(Postulacion::class);
    }
    public function usuarioPostulante()
    {
        return $this->belongsTo(Usuario::class);
    }
}
