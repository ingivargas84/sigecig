<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoDeCuentaMaestro extends Model
{
    protected $table='sigecig_estado_de_cuenta_maestro';

    protected $fillable=[
        'colegiado_id',
        'estado_id',
        'fecha_creacion',
        'usuario_id',
    ];
}
