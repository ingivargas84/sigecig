<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SigecigSaldoColegiados extends Model
{
    protected $table='sigecig_estado_cuenta_saldo';

    protected $fillable=[
        'no_colegiado',
        'mes_id',
        'año',
        'saldo',
        'fecha',
    ];
}
