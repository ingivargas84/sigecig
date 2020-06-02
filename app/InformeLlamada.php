<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformeLlamada extends Model
{
    use SoftDeletes;

    protected $table = 'sigecig_informe_llamadas';

    protected $dates = ['deleted_at'];

    protected $fillable =[
        'fecha_hora',
        'colegiado',
        'telefono',
        'observaciones',
        'userid'
    ];
}
