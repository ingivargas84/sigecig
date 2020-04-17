<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoSolicitud extends Model
{
    protected $table='estado_solicitud';
    
    protected $fillable=[
        'estado_solicitud'
    ];
}
