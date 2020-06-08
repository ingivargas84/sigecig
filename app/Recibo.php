<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table = 'sigecig_recibo';

    protected $fillable = [
        'id',
        'serie_recibo_id',
        'numero_recibo',
        'numero_de_identificacion',
        'tipo_de_cliente_id',
        'complemento',
        'monto_efecectivo',
        'monto_tarjeta',
        'monto_cheque',
        'usuario',
        'monto_total'
    ];
}
