<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cajas extends Model
{
    use SoftDeletes;
    protected $table='sigecig_cajas';
    protected $dates=['deleted_at'];

    protected $fillable=[
        'nombre_caja',
        'cajero',
        'subsede'
    ];
}
