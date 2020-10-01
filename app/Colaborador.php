<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'sigecig_colaborador';

    protected $fillable = [
        'id',
        'nombre',
        'dpi',
        'departamento_dpi_id',
        'municipio_dpi_id',
        'puesto',
        'departamento',
        'subsede',
        'telefono',
        'estado',
        'usuario'


    ];
}
