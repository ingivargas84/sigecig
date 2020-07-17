<?php

use Illuminate\Database\Seeder;
use App\EstadoDeEstadosDeCuenta;

class EstadoDeEstadosDeCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estado_de_estado_de_cuenta')->insert([
            'estado'=>'Activo'
        ]);
        DB::table('sigecig_estado_de_estado_de_cuenta')->insert([
            'estado'=>'Inactivo'
        ]);
    }
}
