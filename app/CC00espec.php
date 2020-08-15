<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CC00espec extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'cc00espec';
    protected $primaryKey = 'c_cliente';
    protected $keyType = 'string';
    public $timestamps = false;
}
