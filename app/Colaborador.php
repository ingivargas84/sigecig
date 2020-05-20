<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'sigecig_colaborador';

    protected $fillable = [
        'nombre',
        'dpi',
        'puesto',
        'departamento',
        'telefono',
        'estado',
        'usuario'


    ];
}
