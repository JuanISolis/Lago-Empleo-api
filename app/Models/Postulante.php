<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    //
     protected $fillable = [
        'ci',
        'foto_perfil',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'sexo',
        'contacto',
        'direccion',
        'profesion',
        'descripcion',
        'discapacidad',
        'tipo_discapacidad',
        'porcent_discapacidad',
    ];
}
