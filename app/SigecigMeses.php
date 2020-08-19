<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SigecigMeses extends Model
{
    protected $table='sigecig_meses';

    protected $fillable=[
        'id',
        'mes'
    ];
}
