<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorteCaja extends Model
{
    protected $table='sigecig_corte_de_caja';
    protected $dates=['deleted_at'];

    protected $fillable=[
        'monto_total',
        'total_efectivo',
        'total_cheque',
        'total_tarjeta',
        'total_deposito',
        'id_caja',
        'id_usuario',
        'fecha_corte' 
    ];

    public function reciboMaestro() {
        return $this->belongsTo('\App\Recibo_Maestro', 'id');
      }
}
