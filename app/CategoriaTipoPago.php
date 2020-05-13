<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaTipoPago extends Model
{
    protected $table = 'sigecig_categoria_tipo_pago';

    protected $fillable=[
        'categoria'
    ];
}
