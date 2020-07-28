<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'mpo';
  protected $primaryKey = 'c_mpo';
  public $timestamps = false;
    //
}
