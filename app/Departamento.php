<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'sigecig_departamento';

    protected $fillable = [
        'nombre_departamento'
    ];
}
