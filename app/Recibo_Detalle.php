<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo_Detalle extends Model
{
    protected $table = 'sigecig_recibo_detalle';

    protected $fillable = [
        'id',
        'numero_recibo',
        'codigo_compra',
        'cantidad',
        'precio_unitario',
        'total'
    ];
}
