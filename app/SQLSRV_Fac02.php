<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Fac02 extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'FAC02';

    protected $fillable = [
        'num_fac'
    ];
}
