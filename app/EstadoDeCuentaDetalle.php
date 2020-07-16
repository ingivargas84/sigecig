<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoDeCuentaDetalle extends Model
{
    protected $table='sigecig_estado_de_cuenta_detalle';

    protected $fillable=[
        'id_maestro',
        'fecha_pago',
        'estado_actual',
        'saldo_total'
    ];
}
