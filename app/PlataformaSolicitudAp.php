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
        'no_cuenta',
        'no_solicitud',
        'no_acta',
        'no_punto_acta',       
        'pdf_dpi_ap',
        'pdf_solicitud_ap',
        'fecha_pago_ap'  
    ];

}
