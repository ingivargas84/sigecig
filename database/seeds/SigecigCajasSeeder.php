<?php

use Illuminate\Database\Seeder;
use App\Cajas;

class SigecigCajasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $caja=new Cajas();
        $caja->nombre_caja="Compras en linea";
        $caja->cajero="3";
        $caja->subsede="1";
        $caja->bodega="1";
        $caja->estado=1;
        $caja->save();
    }
  
}
