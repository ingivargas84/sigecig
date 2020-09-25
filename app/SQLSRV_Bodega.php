<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Bodega extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'INV02';

    protected $fillable = [
        'c_bodega',
    ];
}
