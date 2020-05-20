<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdmPersona extends Model
{
    protected $table= 'adm_persona';
  
    protected $fillable=[
        'idPersona',
        'Nombre1',
    ];
}
