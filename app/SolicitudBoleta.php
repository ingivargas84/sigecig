<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudBoleta extends Model
{
    protected $table='solicitud_boleta';

    protected $fillable=[
        'fecha',
        'departamento_id',
        'descripcion_boleta',
        'responsable',
        'user_id',
        'estado_solicitud',
        'quien_la_usara'
    ];
}
