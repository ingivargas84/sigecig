<?php

use Illuminate\Database\Seeder;
use App\EstadoAnulacionRecibo;

class EstadosAnulacionRecibosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estados_anulacion_recibos')->insert([
            'estado_recibo'=>'En Revisión'
        ]);
        DB::table('sigecig_estados_anulacion_recibos')->insert([
            'estado_recibo'=>'Inactivo'
        ]);
    }
}
