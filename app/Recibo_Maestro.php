<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo_Maestro extends Model
{
    protected $table = 'recibo_maestro';

    protected $fillable = [
        'fecha_recibo', //fecha del recibo
        'serie', //serie del recibo
        'num_recibo', //numero de recibo
        'no_colegiado', //número de colegiado
        'nombre_colegiado', //nombre de colegiado
        'anulado', //recibo anulado o no
        'efectivo', //cobro en efectivo
        'tarjeta', //cobro en tarjeta
        'cheque', //cobro en cheque
        'total_recibo', //total del recibo
        'fecha_ingreso', //fecha y hora creación
    ];
}
