<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibreriaIdioma extends Model
{
    protected $fillable = [
        'idioma',
    ];
    
    public function habilidades()
    {
        return $this->hasMany(Idioma::class);
    }
}
