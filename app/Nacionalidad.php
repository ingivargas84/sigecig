<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'nacionalidades';
  protected $primaryKey = 'c_nacionalidad';
  public $timestamps = false;
}
