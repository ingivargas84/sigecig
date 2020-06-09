<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosCobro extends Model
{
    protected $table = 'sigecig_pos_cobro';

    protected $fillable = [
        'pos_cobro'
    ];
}
