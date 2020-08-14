<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiposDeProductos extends Model
{
    protected $table='sigecig_tipos_de_productos';

    protected $fillable=[
        'tipo_de_pago_id',
        'timbre_id',
    ];

}
