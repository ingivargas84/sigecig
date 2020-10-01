<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodegas extends Model
{
    protected $table='sigecig_bodega';
    protected $dates=['deleted_at'];

    protected $fillable=[
        'nombre_bodega',
        'descripcion',
        'estado' //este estado es el que nos indica si se encuentra activado (1) o desactivado (0).

    ];
}
