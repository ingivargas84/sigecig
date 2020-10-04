<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table='sigecig_estados';

    protected $fillable=[
        'estado'
    ];
}
