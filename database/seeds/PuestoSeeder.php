<?php

use Illuminate\Database\Seeder;
use app\Puesto;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'gerente'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Presidente'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Sala de juntas'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Sub Gerente'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Secretaria de Gerencia'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Secretaria de Junta Directiva'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Compras'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Nuevos Colegiados'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Tribunal de Honor'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Tribunal Electoral'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Cajas'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Soporte Tecnico'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Desarrollador'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Jefe de Computo'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Auxiliar de Timbre'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Administrador de Timbre'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Macro Seguros'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Jefe de CEDUCA'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Secretaria CEDUCA'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Asistente de Comisiones'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'ASIJUGUA'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Contador General'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Auditor Interno'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Contadora de Timbre'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Auxiliar de Contabilidad'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Mensajeria'
        ]);
        DB::table('sigecig_puesto')->insert([
            'puesto'=>'Garita'
        ]);        
    }
}
