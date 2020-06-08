<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReciboCheque extends Model
{
    protected $table = 'sigecig_recibo_cheque';

    protected $fillable = [
        'numero_recibo',
        'numero_cheque',
        'monto',
        'nombre_banco',
        'usuario_id',
        'fecha_de_cheque'
    ];
}
