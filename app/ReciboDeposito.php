<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboDeposito extends Model
{
    protected $table = 'sigecig_recibo_deposito';

    protected $fillable = [
        'numero_recibo',
        'monto',
        'numero_boleta',
        'fecha',
        'banco_id',
        'usuario_id'
    ];
}
