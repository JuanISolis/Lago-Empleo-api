<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibreriaHabilidad extends Model
{
    protected $fillable = [
        'habilidad',
    ];
    
    public function habilidades()
    {
        return $this->hasMany(Habilidad::class);
    }
}
