<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    protected $fillable = [
        'libreria_habilidades_id',
        'postulante_id',
    ];

    public function libreria_habilidads()
    {
        return $this->belongsTo(LibreriaHabilidad::class);
    }

}
