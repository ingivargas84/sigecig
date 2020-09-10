<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SigecigEnvios extends Model
{
    protected $table='sigecig_envios';

    protected $fillable=[
        'id',
        'id_recibo_maestro',
        'id_forma_entrega',
        'id_municipio',
        'id_departamento',
        'detalle_direccion',
        'referencias',
        'telefono',
        'encargado',
        'dpi_encargado',
        'id_sede',
    ];
}
