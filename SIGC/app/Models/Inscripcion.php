<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
      protected $table = 'inscripciones';
    protected $fillable = [
        'user_id',
        'capacitacion_id',
        'estado',
    ];
}
