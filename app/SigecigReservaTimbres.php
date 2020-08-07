<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SigecigReservaTimbres extends Model
{
    protected $table='sigecig_reserva_timbre';

    protected $fillable=[
        'id',
        'id_ingreso_producto',
        'no_colegiado',
        'cantidad',
        'estado',
        'fecha_hora',
    ];
}
