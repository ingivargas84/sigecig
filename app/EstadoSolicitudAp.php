<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoSolicitudAp extends Model
{
    protected $table='sigecig_estado_solicitud_ap';
    
    protected $fillable=[
        'estado_solicitud_ap'
    ];
}
