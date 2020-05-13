<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subsedes extends Model
{
    use SoftDeletes;
    protected $table='sigecig_subsedes';
    protected $dates=['deleted_at'];

    protected $fillable=[
        'nombre_sede',
        'direccion',
        'telefono',
        'telefono_2',
        'correo_electronico',
        'estado'
    ];

}
