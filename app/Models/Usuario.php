<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Usuario extends Model
{
    protected $table = 'usuarios';
    
    protected $fillable = [
        'user_id',
        'ci',
        'foto_perfil',
        'nombre',
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
