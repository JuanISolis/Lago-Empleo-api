<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OfertaLaboral extends Model
{
    use HasFactory;

    protected $table = 'oferta_laboral';

    protected $fillable = [
        'id_informacion_empresa',
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
        'estado'
    ];

    public function informacionEmpresa()
    {
        return $this->belongsTo(InformacionEmpresa::class, 'id_informacion_empresa');
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'id_ofertalaboral');
    }
}