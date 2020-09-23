<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Fac01 extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'FAC01';

    protected $fillable = [
        'num_fac'
    ];
}
