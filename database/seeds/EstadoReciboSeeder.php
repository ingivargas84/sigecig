<?php

use Illuminate\Database\Seeder;
use App\EstadoRecibo;

class EstadoReciboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estado_recibo')->insert([
            'estado_recibo'=>'Activo'
        ]);
        DB::table('sigecig_estado_recibo')->insert([
            'estado_recibo'=>'En Revisión'
        ]);
        DB::table('sigecig_estado_recibo')->insert([
            'estado_recibo'=>'Inactivo'
        ]);
    }
}
