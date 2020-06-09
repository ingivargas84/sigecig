<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRecibo extends Model
{
    protected $table = 'sigecig_detalle_recibo';

    protected $fillable = [
        'numero_recibo',
        'codigo_compra',
        'cantidad',
        'precio_unitario',
        'total'
    ];
}
