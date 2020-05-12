<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'sigecig_puesto';

    protected $fillable = [
        'puesto'
    ];
}
