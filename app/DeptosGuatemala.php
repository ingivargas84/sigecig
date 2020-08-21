<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeptosGuatemala extends Model
{
    protected $table = 'adm_departamento';

    protected $fillable = [
        'iddepartamento',
        'nombre',
        'estado'
    ];
}
