<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EspecialidadAspirante extends Model
{
    
  protected $connection = 'sqlsrv';
  protected $table = 'especialidadAspirante';
  protected $primaryKey = 'dpi';
  public $timestamps = false;
}
