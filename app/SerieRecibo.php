<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SerieRecibo extends Model
{
    protected $table = 'sigecig_serie_recibo';

    protected $fillable = [
        'serie_recibo',
        'detalle'
    ];
}
