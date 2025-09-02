<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformacioEmpresa extends Model
{
    protected $table = 'informacio_empresas';

    // Campos que se pueden llenar en masa
    protected $fillable = [
        'ruc',
        'nombre_empresa',
        'imagen_empresa',
        'descripcion',
        'usuario_id'
    ];

    // Relación con usuario 
    //La función usuario() define la relación con la tabla usuarios, útil para obtener el dueño de la empresa.
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id'); //belongsTo indica que esta empresa pertenece a un usuario.
    }

    //IMPORTANTE LEER 
    //Estás usando User::class pero tu proyecto parece usar Usuario como modelo. Debería ser:
}
