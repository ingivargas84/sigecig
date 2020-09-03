<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SigecigTimbres extends Model
{
    protected $table='sigecig_timbres';

    protected $fillable=[
        'id',
        'descripcion',
    ];
}
