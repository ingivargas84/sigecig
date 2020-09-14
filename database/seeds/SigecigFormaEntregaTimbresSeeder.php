<?php

use Illuminate\Database\Seeder;

class SigecigFormaEntregaTimbresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formaEntrega =  new \App\SigecigFormaEntregaTimbres;
        $formaEntrega->forma_entrega='Envío a domicilio';
        $formaEntrega->estado = 1;
        $formaEntrega->save();

        $formaEntrega =  new \App\SigecigFormaEntregaTimbres;
        $formaEntrega->forma_entrega='Recoge en bodega';
        $formaEntrega->estado = 1;
        $formaEntrega->save();
    }
}
