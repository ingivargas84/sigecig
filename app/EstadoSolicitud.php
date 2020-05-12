<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoSolicitud extends Model
{
    protected $table='sigecig_estado_solicitud';
    
    protected $fillable=[
        'estado_solicitud'
    ];
}
