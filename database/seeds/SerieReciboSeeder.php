<?php

use Illuminate\Database\Seeder;
use App\SerieRecibo;

class SerieReciboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_serie_recibo')->insert([
            'serie_recibo'=>'A',
            'detalle'=>'Serie que sirve para registrar los pagos de colegiatura y varios'
        ]);
        DB::table('sigecig_serie_recibo')->insert([
            'serie_recibo'=>'B',
            'detalle'=>'Serie que sirve para registrar los pagos de timbres'
        ]);
    }
}
