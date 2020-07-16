<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoDeCuentaMaestro extends Model
{
    protected $table='sigecig_estado_de_cuenta_maestro';

    protected $fillable=[
        'numero_colegiado'
    ];
}
