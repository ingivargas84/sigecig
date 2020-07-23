<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoDeCuentaDetalle extends Model
{
    protected $table='sigecig_estado_de_cuenta_detalle';

    protected $fillable=[
        'estado_cuenta_maestro_id',
        'cantidad',
        'tipo_pago_id',
        'recibo_id',
        'abono',
        'cargo',
        'usuario_id',
        'estado_id'
    ];
}
