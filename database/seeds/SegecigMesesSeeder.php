<?php

use Illuminate\Database\Seeder;
use App\SigecigMeses;

class SegecigMesesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bco=new SigecigMeses();
        $bco->mes="Enero";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Febrero";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Marzo";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Abril";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Mayo";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Junio";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Julio";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Agosto";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Septiembre";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Octubre";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Noviembre";
        $bco->save();
        $bco=new SigecigMeses();
        $bco->mes="Diciembre";
        $bco->save();

    }
}
