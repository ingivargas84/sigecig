<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Producto extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'PRODUCTO';

    protected $fillable = [
        'id',
        'descripcion',
        'activo',
        'particular',
        'empresa',
        'tipoCliente',
        'variable',
        'categoria_id',
        'estado_id',
    ];
}
