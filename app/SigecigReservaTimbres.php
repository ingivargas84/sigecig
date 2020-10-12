<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SigecigReservaTimbres extends Model
{
    protected $table='sigecig_reserva_timbre';

    protected $fillable=[
        'id',
        'id_ingreso_producto',
        'id_tipo_pago',//define el tipo de producto timbre que se esta reservando
        'id_categoria_pago', //define la categoria de timbre (TC  || TIM)
        'no_colegiado',
        'cantidad',
        'estado',
        'fecha_hora',
    ];
}
