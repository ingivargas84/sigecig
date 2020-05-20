<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Empresa extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'MAEEMPR';

    protected $fillable = [
        'id',
        'CODIGO',
        'EMPRESA',
        'DIRECCION',
        'DEPTO',
        'MUNICIPIO',
        'TELEFONO1',
        'TELEFONO2',
        'TELEFONO3',
        'FAX',
        'CONTACTO',
        'NIT',
        'PAGO_TIM',
        'r_legal',
        'estado',
        'e_mail',
        'zona',
        'folio',
        'libro',
        'categoria',
        'c_cliente',
        'fecha',
        'memo',
        'usuario_agrego',
        'ip',
        'f_creacion',
        'std'
    ];
}
