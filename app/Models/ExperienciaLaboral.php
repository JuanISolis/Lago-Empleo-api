<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    use HasFactory;

    protected $table = 'experiencia_laborals'; // igual que migración

    protected $fillable = [
        'postulante_id',
        'lugar_trabajo',
        'cargo',
        'fecha_inicio',
        'fecha_fin',
        'descripcion', // <-- agregado
    ];

    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
}
