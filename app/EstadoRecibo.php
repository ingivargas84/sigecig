<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoRecibo extends Model
{
    protected $table='sigecig_estado_recibo';

    protected $fillable=[
        'estado_recibo'
    ];
}
