<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Profesion extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'cc00prof';

    protected $fillable = [
        'id',
        'c_cliente',  //no de colegiado
        'c_profesion',  //codigo de profesión
        'n_profesion'  //nombre de la profesión
    ];
}
