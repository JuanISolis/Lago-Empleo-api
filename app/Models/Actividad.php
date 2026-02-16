<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $fillable = [
        'user_id',
        'tipo',
        'descripcion',
        'rol',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
