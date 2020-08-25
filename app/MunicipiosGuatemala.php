<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MunicipiosGuatemala extends Model
{
    protected $table = 'adm_municipio';

    protected $fillable = [
        'idmunicipio',
        'iddepartamento',
        'nombre',
        'estado'
    ];
}
