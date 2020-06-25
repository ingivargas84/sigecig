<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class TipoDePago extends Model
{
    use SoftDeletes;

    protected $table = 'sigecig_tipo_de_pago';

    protected $dates = ['deleted_at'];

    protected $fillable=[
        'codigo',
        'tipo_de_pago',
        'precio_colegiado',
        'precio_particular',
        'categoria_id',
        'estado' //este estado es el que nos indica si se encuentra activado (0) o desactivado (1).
    ];

}
