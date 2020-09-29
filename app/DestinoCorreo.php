<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinoCorreo extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'destino_correo';

  protected $fillable=[
    'destino'
];
  //public $timestamps = false;
}
