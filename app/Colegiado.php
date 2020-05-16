<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colegiado extends Model
{
    protected $table='cc00';

    protected $fillable=[
        'n_cliente',  //Nombre de colegiado
        'c_cliente',  //numero de colegiado
        'estado',   //Status (activo, inactivo o fallecido)
        'f_ult_timbre',  //fecha del ultimo pago de timbre
        'f_ult_pago'  //fecha del ultimo pago de colegiatura

    ];
}
