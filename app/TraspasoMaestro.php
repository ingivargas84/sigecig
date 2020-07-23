<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TraspasoMaestro extends Model
{
    protected $table = 'sigecig_traspaso_maestro';

    protected $fillable = [
        'bodega_origen_id',
        'bodega_destino_id',
        'cantidad_de_timbres',
        'total_en_timbres',
        'fecha_ingreso',
        'usuario_id'
    ];
}
