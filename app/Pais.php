<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'pais';
  protected $primaryKey = 'c_pais';
  public $timestamps = false;
    //
}
