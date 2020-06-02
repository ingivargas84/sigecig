<?php

use Illuminate\Database\Seeder;
use App\EstadoSolicitud;

class EstadoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estado_solicitud')->insert([
            'estado_solicitud'=>'creada'
        ]);
        DB::table('sigecig_estado_solicitud')->insert([
            'estado_solicitud'=>'rechazado'
        ]);
        DB::table('sigecig_estado_solicitud')->insert([
            'estado_solicitud'=>'aprobado'
        ]);
    }
}
