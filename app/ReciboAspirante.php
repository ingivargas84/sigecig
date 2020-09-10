<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboAspirante extends Model
{
    protected $table = 'sigecig_recibo_aspirante';

    protected $fillable = [
        'id',
        'numero_recibo',
        'id_aspirante'
    ];
}
