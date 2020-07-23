<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoDeEstadosDeCuenta extends Model
{
    protected $table='sigecig_estado_de_estado_de_cuenta';

    protected $fillable=[
        'estado'
    ];
}
