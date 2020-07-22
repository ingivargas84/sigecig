<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoBodegaMaestro extends Model
{
    protected $table='sigecig_ingreso_bodega_maestro';

    protected $fillable=[
        'usuario_id',
        'cantidad_de_timbres',
        'total',
        'codigo_bodega_id',
    ];
}
