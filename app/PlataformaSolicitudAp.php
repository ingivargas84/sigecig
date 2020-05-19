<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlataformaSolicitudAp extends Model
{
    protected $table = 'plataforma_solicitudes_ap';

    protected $fillable = [
        'id',
        'fecha_solicitud',
        'n_colegiado',
        'id_estado_solicitud',
        'id_banco',
        'id_tipo_cuenta',
        'no_cuenta'
    ];
}
