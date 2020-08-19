<?php

use Illuminate\Database\Seeder;
use App\Bodegas;

class SigecigBodegaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bodega=new Bodegas();
        $bodega->nombre_bodega="Bodega Ventas en Linea";
        $bodega->descripcion="Bodega Ventas en Linea";
        $bodega->estado=1;
        $bodega->save();

        $bodega=new Bodegas();
        $bodega->nombre_bodega="Bodega Central";
        $bodega->descripcion="Bodega Central";
        $bodega->estado=1;
        $bodega->save();
    }
}
