<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Usuario;
use App\Models\Actividad;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'rol',
        'estado',
        'recuperacion',
    ];
    
    public function usuario()
    {
        return $this->hasOne(Usuario::class);
    }

    public function actividad()
    {
        return $this->hasOne(Actividad::class);
    }

}
