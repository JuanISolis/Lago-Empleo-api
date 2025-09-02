<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    protected $fillable = [
        'postulante_id',
        'lugar_trabajo',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
