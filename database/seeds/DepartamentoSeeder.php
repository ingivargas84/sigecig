<?php

use Illuminate\Database\Seeder;
use app\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'gerencia'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'informatica'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'timbre'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'secretaria'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'ceduca'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'contabilidad'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'cajeros'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'mensajeria'
        ]);
        DB::table('sigecig_departamento')->insert([
            'nombre_departamento'=>'mantenimiento'
        ]);
    }
}
