<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Postulacion extends Model
{
    use HasFactory;

    protected $table = 'postulacion';

    protected $fillable = [
        'id_ofertalaboral',
        'id_postulante',
        'fecha_postulacion',
        'estado'
    ];

    public function ofertaLaboral()
    {
        return $this->belongsTo(OfertaLaboral::class, 'id_ofertalaboral');
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class, 'id_postulante');
    }
}
