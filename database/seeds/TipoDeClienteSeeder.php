<?php

use Illuminate\Database\Seeder;
use App\TipoDeCliente;

class TipoDeClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_tipo_de_cliente')->insert([
            'tipo_de_cliente'=>'Colegiado'
        ]);
        DB::table('sigecig_tipo_de_cliente')->insert([
            'tipo_de_cliente'=>'Particular'
        ]);
        DB::table('sigecig_tipo_de_cliente')->insert([
            'tipo_de_cliente'=>'Empresa'
        ]);
    }
}
