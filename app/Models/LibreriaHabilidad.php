<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibreriaHabilidad extends Model
{

    protected $table = 'libreria_habilidads';

    protected $fillable = [
        'habilidad',
    ];
    
    public function habilidades()
    {
        return $this->hasMany(Habilidad::class, 'libreria_habilidades_id');
    }
}
