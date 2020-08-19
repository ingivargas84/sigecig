<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoBodegaDetalle extends Model
{
    protected $table='sigecig_ingreso_bodega_detalle';

    protected $fillable=[
        'fecha_ingreso',
        'ingreso_maestro_id',
        'timbre_id',
        'planchas',
        'unidad_por_plancha',
        'numeracion_inicial',
        'numeracion_final',
        'cantidad',
        'total',
        'usuario_id',
    ];
}
