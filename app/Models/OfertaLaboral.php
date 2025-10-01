<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InformacionEmpresa;
use App\Models\Postulacion;


class OfertaLaboral extends Model
{
    
    protected $fillable = [
        'titulo_ofertalaboral',
        'descripcion',
        'ubicacion',
        'jornada',
        'fecha_inicio',
        'pago',
        'num_trabajadores',
        'experiencia',
        'nivel_estudio',
        'edad',
        'estado',
        'informacion_empresa_id'
    ];

    public function informacionEmpresas()
    {
        return $this->belongsTo(InformacionEmpresa::class); 
    }
    
    public function Postulacion()
    {
        return $this->hasMany(Postulacion::class); 
    }

}
