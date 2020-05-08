<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoBoleta extends Model
{
    protected $table='sigecig_estado_boleta';

    protected $fillable=[
        'estado_boleta'
    ];
}
