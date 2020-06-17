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
            'estado_solicitud_ap'=>'Documentos Enviados'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Documentación Rechazada'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Documentación Aprobada'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Aprobado por Junta'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Rechazado por Junta'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Ingreso de acta'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Resolución Firmada'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Configuración de Pago'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Finalizada'
        ]);
        DB::table('sigecig_estado_solicitud_ap')->insert([
            'estado_solicitud_ap'=>'Anulada'
        ]);

    }
}
