<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlataformaSolicitudAp extends Model
{
    protected $table = 'sigecig_solicitudes_ap';

    protected $fillable = [
        'id',
        'fecha_solicitud',
        'n_colegiado',
        'id_estado_solicitud',
        'id_banco',
        'id_tipo_cuenta',
        'estado',
        'no_cuenta',
        'no_acta',
        'no_punto_acta',
        'no_solicitud'
    ];

}
