<?php

use Illuminate\Database\Seeder;

class TimbresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q1.00',
        ]);
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q5.00',
        ]);
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q10.00',
        ]);
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q20.00',
        ]);
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q50.00',
        ]);
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q100.00',
        ]);
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q200.00',
        ]);
        DB::table('sigecig_timbres')->insert([
            'descripcion'=>'Timbres de precio de Q500.00',
        ]);
    }
}
