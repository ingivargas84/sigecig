<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActaMaestro extends Model
{
    protected $table = 'sigecig_acta_maestro';

    protected $fillable = [
        'no_acta',
        'fecha_acta',
        'pdf_acta',
        'estado'
    ];
}
