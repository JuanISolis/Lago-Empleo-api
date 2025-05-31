<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// MODELO INFORMACIÓN EMPRESA
class InformacionEmpresa extends Model
{
    use HasFactory;

    protected $table = 'informacion_empresa';

    protected $fillable = [
        'id_empleador',
        'ruc',
        'imagen_empresa',
        'nombre_empresa',
        'descripcion'
    ];

    public function empleador()
    {
        return $this->belongsTo(Usuario::class, 'id_empleador');
    }

    public function ofertasLaborales()
    {
        return $this->hasMany(OfertaLaboral::class, 'id_informacion_empresa');
    }
}
