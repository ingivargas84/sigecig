<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anulacion extends Model
{
    protected $table = 'sigecig_anulacion';

    protected $fillable = [
        'id',
        'fecha_solicitud',
        'razon_solicitud',
        'usuario_cajero_id',
        'recibo_id',
        'estado_recibo_id',
        'fecha_aprueba_rechazo',
        'usuario_aprueba_rechaza',
        'razon_rechazo',
    ];
}
