<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CC00prof extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'cc00prof';
    protected $primaryKey = 'c_cliente';
    protected $keyType = 'string';
    public $timestamps = false;
}
