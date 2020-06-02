<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class PlataformaBanco extends Model
{
    protected $table = 'sigecig_bancos';

    protected $fillable = [
        'id',
        'nombre_banco'
    ];
}
