<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $table = 'idiomas';

    protected $fillable = [
        'libreria_idiomas_id',
        'postulante_id',
        'nivel',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
    public function libreria_idioma()
    {
        return $this->belongsTo(LibreriaIdioma::class, 'libreria_idiomas_id');
    }
}

