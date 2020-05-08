<?php

use Illuminate\Database\Seeder;
use App\Negocio;

class NegocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sigecig_negocio = new Negocio();
        $sigecig_negocio->save();

    }
}
