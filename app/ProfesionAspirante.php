<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfesionAspirante extends Model
{
    
  protected $connection = 'sqlsrv';
  protected $table = 'profesionAspirante';
  protected $primaryKey = 'dpi';
  public $timestamps = false;
}
