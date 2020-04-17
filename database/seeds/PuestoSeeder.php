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
        DB::table('puesto')->insert([
            'puesto'=>'gerente'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Presidente'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Sala de juntas'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Sub Gerente'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Secretaria de Gerencia'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Secretaria de Junta Directiva'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Compras'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Nuevos Colegiados'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Tribunal de Honor'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Tribunal Electoral'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Cajas'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Soporte Tecnico'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Desarrollador'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Jefe de Computo'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Auxiliar de Timbre'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Administrador de Timbre'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Macro Seguros'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Jefe de CEDUCA'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Secretaria CEDUCA'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Asistente de Comisiones'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'ASIJUGUA'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Contador General'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Auditor Interno'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Contadora de Timbre'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Auxiliar de Contabilidad'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Mensajeria'
        ]);
        DB::table('puesto')->insert([
            'puesto'=>'Garita'
        ]);        
    }
}
