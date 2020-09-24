<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Prod extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'INV00';

    protected $fillable = [
        'id',
    ];
}
