<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmColegiado extends Model
{
    protected $table = 'adm_colegiado';

    protected $fillable=[
        'idColegiado',
        'idUsuario',
        'numerocolegiado',
        'fechacreacion',
        'estado'
    ];
}
