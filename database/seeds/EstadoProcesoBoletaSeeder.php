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
        DB::table('estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'lista'
        ]);
        DB::table('estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'entregada'
        ]);
        DB::table('estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'usada'
        ]);
        DB::table('estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'regresado'
        ]);
        DB::table('estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'liquidado'
        ]);
        DB::table('estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'perdido'
        ]);
        DB::table('estado_proceso_boleta')->insert([
            'estado_proceso_boleta'=>'anulada'
        ]);
    }
}
