<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo_Maestro extends Model
{
    protected $table = 'sigecig_recibo_maestro';

    protected $fillable = [
        'id',
        'serie_recibo_id',
        'numero_recibo',
        'numero_de_identificacion', //este dato puede ser #coleigado, nit o dpi
        'nombre',
        'tipo_de_cliente_id',
        'complemento',
        'monto_efecectivo',
        'monto_tarjeta',
        'monto_cheque',
        'monto_deposito',
        'usuario',
        'monto_total',
        'e_mail',
        'id_corte_de_caja',
        'estado_recibo_id'
    ];
    public function corte() {
        return $this->belongsTo('\App\CorteCaja', 'id');
      }

}
