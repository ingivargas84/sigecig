<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraspasoDetalle extends Model
{
    protected $table = 'sigecig_traspaso_detalle';

    protected $fillable = [
        'traspaso_maestro_id',
        'tipo_pago_timbre_id',
        'cantidad_a_traspasar'
    ];
}
