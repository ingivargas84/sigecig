<?php

use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_estados')->insert([
            'estado'=>'Activo'
        ]);
        DB::table('sigecig_estados')->insert([
            'estado'=>'Inactivo'
        ]);
    }
}
