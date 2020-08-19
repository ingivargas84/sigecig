<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'profesion';
  protected $primaryKey = 'c_profesion';
  public $timestamps = false;
  protected $keyType = 'string';
    //
}
