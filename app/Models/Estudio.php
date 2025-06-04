<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    protected $fillable = [
        'titulo',
        'unidad_educativa',
        'modalidad',
        'doc_titulo',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
