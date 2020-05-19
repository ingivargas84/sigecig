<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDeCliente extends Model
{
    protected $table='sigecig_tipo_de_cliente';

    protected $fillable=[
        'tipo_de_cliente'
    ];
}
