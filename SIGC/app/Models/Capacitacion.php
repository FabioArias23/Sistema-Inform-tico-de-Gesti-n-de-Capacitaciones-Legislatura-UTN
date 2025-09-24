<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    protected $table = 'Capacitaciones';

  protected $fillable = [
    'tematica',
    'nombre',
    'descripcion',
    'modalidad',
    'fecha_inicio',
    'fecha_fin',
    'hora_inicio',
    'hora_fin',
    'cupos',
    'cupos_disponibles',
    'imagen_destacada',
];
}
