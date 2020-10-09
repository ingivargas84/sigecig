<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_ConstanciaElectronica extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'constancia_electronica';

    protected $fillable = [
        'id',
        'numero',
        'colegiado',
        'nombre',
        'fecha_activo_hasta',
        'fecha_generacion_impresa',
        'fecha_generacion',
        'uuid',
        'motivo',
        'contador',
        'correlativo',
        'llave',
        'estado_id',
        'recibo_id',
    ];
}
