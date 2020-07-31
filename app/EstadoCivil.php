<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'e_civil';
    protected $primaryKey = 'c_civil';
    public $timestamps = false;
}
