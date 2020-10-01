<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SigecigFormaEntregaTimbres extends Model
{
    protected $table='sigecig_forma_entrega_timbre';

    protected $fillable=[
        'id',
        'forma_entrega',
        'estado', //1 activo
    ];
}
