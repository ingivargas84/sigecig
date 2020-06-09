<?php

use Illuminate\Database\Seeder;
use App\PosCobro;

class PosCobroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_pos_cobro')->insert([
            'pos_cobro'=>'VISA'
        ]);
        DB::table('sigecig_pos_cobro')->insert([
            'pos_cobro'=>'CREDOMATIC'
        ]);
    }
}
