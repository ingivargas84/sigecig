<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'especialidad';
  protected $primaryKey = 'c_especialidad';
  public $timestamps = false;
    //
}
