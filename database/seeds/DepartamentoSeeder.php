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
        DB::table('departamento')->insert([
            'nombre_departamento'=>'gerencia'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'informatica'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'timbre'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'secretaria'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'ceduca'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'contabilidad'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'cajeros'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'mensajeria'
        ]);
        DB::table('departamento')->insert([
            'nombre_departamento'=>'mantenimiento'
        ]);
    }
}
