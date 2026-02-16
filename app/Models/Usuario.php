<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Postulante;
use App\Models\InformacionEmpresa;

class Usuario extends Model
{
    protected $table = 'usuarios';
    
    protected $fillable = [
        'id',
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
    public function postulante()
    {
        return $this->hasOne(Postulante::class);
    }

    public function informacionEmpresa()
    {
        return $this->hasMany(InformacionEmpresa::class);
    }
}
