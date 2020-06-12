<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboTarjeta extends Model
{
    protected $table = 'sigecig_recibo_tarjeta';

    protected $fillable = [
        'numero_recibo',
        'numero_voucher',
        'monto',
        'pos_cobro_id',
        'usuario_id'
    ];
}
