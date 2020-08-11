<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoProducto extends Model
{
    protected $table='sigecig_ingreso_producto';

    protected $fillable=[
        'timbre_id',
        'cantidad',
        'bodega_id',
    ];
}
