<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'sigecig_proveedores';

    protected $fillable = [
        'nombre_comercial',
        'nombre_legal',
        'nit',
        'direccion',
        'telefono',
        'email',
        'contacto1',
        'contacto2',
        'estado',
        'user_id',
    ];
}
