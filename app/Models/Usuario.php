<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'user_id',
        'ci',
        'foto_perfil',
        'apellido',
        'fecha_nacimiento',
        'sexo',
        'contacto',
        'direccion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
