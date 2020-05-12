<?php

use Illuminate\Database\Seeder;
use App\EstadoSolicitudAp;

class EstadoSolicitudApSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Creada'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'DocEnviados'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'RechazadaDoc'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'EnviadaJunta'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'AprobadaJunta'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'RechazadaJunta'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'ResolucionFirmada'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'PagoConfigurado'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Finalizada'
        ]);
    }
}
