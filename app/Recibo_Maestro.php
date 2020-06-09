<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo_Maestro extends Model
{
    protected $table = 'sigecig_recibo_maestro';

    protected $fillable = [
        'serie_recibo_id',
        'numero_recibo',
        'numero_de_identificacion', //este dato puede ser #coleigado, nit o dpi
        'tipo_de_cliente_id',
        'complemento',
        'monto_efecectivo',
        'monto_tarjeta',
        'monto_cheque',
        'usuario',
        'monto_total'
    ];
}
