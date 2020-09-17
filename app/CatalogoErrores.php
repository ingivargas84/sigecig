<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogoErrores extends Model
{
    protected $table = 'webservice_catalogo_errores';

    protected $fillable=[
        'id',
        'codigo',
        'descripcion',
        'estado',
    ];
}
