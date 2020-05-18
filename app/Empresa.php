<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'MAEEMPR';

    protected $fillable=[
        'codigo',  //nit de la empresa
        'empresa',  //nombre de la empresa
        'c_cliente'  //numero de colegiado
    ];
}
