<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BitacoraAp extends Model
{
    protected $table = 'sigecig_solicitudes_bitacora_ap';

    protected $fillable = [
        'id',
        'no_solicitud',
        'fecha',
        'estado_solicitud',
        'usuario',
    ];
}
