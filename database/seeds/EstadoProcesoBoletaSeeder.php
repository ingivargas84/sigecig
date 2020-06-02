<?php

use Illuminate\Database\Seeder;
use App\EstadoProcesoBoleta;

class EstadoProcesoBoletaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'lista'
        ]);
        DB::table('sigecig_estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'entregada'
        ]);
        DB::table('sigecig_estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'usada'
        ]);
        DB::table('sigecig_estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'regresado'
        ]);
        DB::table('sigecig_estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'liquidado'
        ]);
        DB::table('sigecig_estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'perdido'
        ]);
        DB::table('sigecig_estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'anulada'
        ]);
    }
}
