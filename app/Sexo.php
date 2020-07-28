<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'sexo';
    protected $primaryKey = 'c_sexo';
    public $timestamps = false;
}
