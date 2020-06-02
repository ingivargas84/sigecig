<?php

use Illuminate\Database\Seeder;
use App\PlataformaBanco;

class PlataformaBancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bco=new PlataformaBanco();
        $bco->nombre_banco="BANRURAL";
        $bco->save();

        $bco=new PlataformaBanco();
        $bco->nombre_banco="Banco Industiral BI";
        $bco->save();

        $bco=new PlataformaBanco();
        $bco->nombre_banco="Credito Hipotecario Nacional CHN";
        $bco->save();

        $bco=new PlataformaBanco();
        $bco->nombre_banco="Banco de America Central BAC";
        $bco->save();

        $bco=new PlataformaBanco();
        $bco->nombre_banco="Banco GyT Continental";
        $bco->save();

        $bco=new PlataformaBanco();
        $bco->nombre_banco="Banco Agromercantil BAM";
        $bco->save();

        $bco=new PlataformaBanco();
        $bco->nombre_banco="Banco de los Trabajadores BANTRAB";
        $bco->save();
    
    }
}
