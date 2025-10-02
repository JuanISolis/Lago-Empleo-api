<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OfertaLaboral;
use App\Models\Postulante;

class Postulacion extends Model
{
    
    protected $fillable = [
        'id',
        'fecha_postulacion',
        'estado',
        'ofertalab_id',
        'postulante_id'
    ];

    public function OfertaLaboral()
    {
        return $this->belongsTo(OfertaLaboral::class);
    }
    

    public function Postulante()
    {
        return $this->belongsTo(Postulante::class);
    }
    
}
