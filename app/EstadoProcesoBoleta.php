<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoProcesoBoleta extends Model
{
    protected $table='sigecig_estado_proceso_boleta';

    protected $fillable=[
        'estado_proceso_boleta'
    ];
}
