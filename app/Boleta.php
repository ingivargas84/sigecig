<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    protected $table='boleta';

    protected $fillable=[
        'no_boleta',
        'nombre_usuario',
        'estado_boleta',
        'estado_proceso',
        'solicitud_boleta_id'
    ];
}
