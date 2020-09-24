<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Vdor extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'VDOR';

    protected $fillable = [
        'c_vendedor',
    ];
}
