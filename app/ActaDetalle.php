<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaDetalle extends Model
{
    protected $table ='sigecig_acta_detalle';

    protected $fillable = [
        'acta_maestro_id',
        'no_punto',
        'detalle_punto'
    ];
}
