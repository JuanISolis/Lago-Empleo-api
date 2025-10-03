<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    protected $fillable = [
        'postulante_id',
        'titulo',
        'unidad_educativa',
        'modalidad',
        'doc_titulo',
    ];

    // Relación con postulante
    public function postulante()
    {
        return $this->belongsTo(Postulante::class);
    }

    // ✅ Accessor para devolver SOLO el nombre del archivo
    public function getDocTituloAttribute($value)
    {
        if ($value) {
            return [
                'nombre' => basename($value), // Solo el nombre del PDF
                'url' => url($value),         // URL completa para descargar
            ];
        }
        return null;
    }
}
