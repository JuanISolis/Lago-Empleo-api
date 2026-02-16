<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{

    protected $table = 'habilidads';

    protected $fillable = [
        'libreria_habilidades_id',
        'postulante_id',
    ];

    public function libreria_habilidad()
    {
        return $this->belongsTo(LibreriaHabilidad::class, 'libreria_habilidades_id');
    }
    public function postulante()
    {
        return $this->belongsTo(Postulante::class, 'postulante_id');
    }

}
