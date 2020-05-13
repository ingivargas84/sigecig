<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlataformaTipoCuenta extends Model
{
    protected $table = 'plataforma_tipo_cuentas';

    protected $fillable = [
        'id',
        'tipo_cuenta'
    ];
}
