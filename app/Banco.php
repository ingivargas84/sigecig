<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'sigecig_bancos';

    protected $fillable = [
        'nombre_banco',
    ];
}
