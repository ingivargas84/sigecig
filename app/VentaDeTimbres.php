<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaDeTimbres extends Model
{
    protected $table = 'sigecig_venta_de_timbres';

    protected $fillable = [
        'recibo_detalle_id',
        'numeracion_inicial',
        'numeracion_final',
        'estado_id',
    ];
}
