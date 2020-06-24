<?php

use Illuminate\Database\Seeder;
use App\TipoDePago;

class TipoDePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'React-TIMBRE',
            'tipo_de_pago'=>'reactivacion de timbre',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0'
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'React-CUOTA-TIM',
            'tipo_de_pago'=>'pago total de colegiatura de reactivacion',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0'
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'React-MORA-TIM',
            'tipo_de_pago'=>'pago total de mora de timbre',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'7',
            'estado'=>'0'
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'React-INT-TIM',
            'tipo_de_pago'=>'pago total de interes de timbre',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'6',
            'estado'=>'0'
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'React-COLEGIADO',
            'tipo_de_pago'=>'reactivacion de colegiatura',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0'
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'React-CUOTA-COL',
            'tipo_de_pago'=>'pago total de cuotas de colegiatura',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0'
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'React-INT-COL',
            'tipo_de_pago'=>'pago total de interes de colegiatura',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'6',
            'estado'=>'0'
        ]);
    }
}
