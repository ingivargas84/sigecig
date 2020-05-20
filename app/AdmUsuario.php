<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmUsuario extends Model
{
    protected $table= 'adm_usuario';
  
    protected $fillable=[
        'idusuario',
        'Usuario',
        'idPersona',
    ];
}
