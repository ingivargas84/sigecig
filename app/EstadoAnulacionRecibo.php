<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoAnulacionRecibo extends Model
{
    protected $table = 'sigecig_estados_anulacion_recibos';

    protected $fillable = [
        'id',
        'estado_recibo',
    ];
}
