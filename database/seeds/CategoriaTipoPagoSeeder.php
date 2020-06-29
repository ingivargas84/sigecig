<?php

use Illuminate\Database\Seeder;
use App\CategoriaTipoPago;

class CategoriaTipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Timbres'
        ]);
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Cursos'
        ]);
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Colegiado'
        ]);
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Constancias'
        ]);
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Nuevos Colegiados'
        ]);
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Interes'
        ]);
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Mora'
        ]);
        DB::table('sigecig_categoria_tipo_pago')->insert([
            'categoria'=>'Otros'
        ]);
    }
}
