<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibreriaIdioma extends Model
{
    protected $table = 'libreria_idiomas';

    protected $fillable = [
        'idioma',
    ];
    
    public function idiomas()
    {
        return $this->hasMany(Idioma::class, 'libreria_idiomas_id');
    }
}
