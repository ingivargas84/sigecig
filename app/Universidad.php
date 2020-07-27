<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universidad extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'universidades';
  protected $primaryKey = 'c_universidad';
  public $timestamps = false;

  public function colegiados()
   {
      return $this->hasMany('\App\Cc00','c_universidad');
   }
    //
}
