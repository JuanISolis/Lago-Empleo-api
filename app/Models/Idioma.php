<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
     protected $fillable = [
        'id_postulante',
        'id_libreria_idiomas',
        'nivel',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
    public function libreriaidioma()
    {
        return $this->belongsTo(LibreriaIdioma::class);
    }
}

