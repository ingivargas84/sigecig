<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDeCuenta extends Model
{
    protected $table='sigecig_tipo_cuentas';

    protected $fillable=[
        'tipo_cuenta'
    ];
}
