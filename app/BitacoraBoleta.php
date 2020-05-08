<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BitacoraBoleta extends Model
{
    protected $table='sigecig_bitacora_boleta';

    protected $fillable=[
        'no_boleta',
        'accion',
        'user_id',
        'fecha'
    ];
}
