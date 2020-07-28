<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartamentoNac extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'deptos1';
  protected $primaryKey = 'c_depto';
  public $timestamps = false;
    //
}
