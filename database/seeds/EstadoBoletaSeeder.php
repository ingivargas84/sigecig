<?php

use Illuminate\Database\Seeder;
use App\EstadoBoleta;

class EstadoBoletaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estado_boleta')->insert([
            'estado_boleta'=>'Activa'
        ]);
        DB::table('sigecig_estado_boleta')->insert([
            'estado_boleta'=>'Inactiva'
        ]);
    }
}
