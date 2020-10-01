<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoProducto extends Model
{
    protected $table='sigecig_ingreso_producto';

    protected $fillable=[
        'timbre_id',
        'cantidad',
        'numeracion_inicial',
        'numeracion_final',
        'bodega_id'
    ];
}
