<?php

use Illuminate\Database\Seeder;
use App\Subsedes;


class SigecigSubsedesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sede=new Subsedes();
        $sede->nombre_sede="Central";
        $sede->direccion="7a. Avenida 39-60 zona 8 Ciudad de Guatemala";
        $sede->telefono="2218-2600";
        $sede->telefono_2="2218-2622";
        $sede->correo_electronico="cajab@cig.org.gt";
        $sede->estado=1;
        $sede->save();
    }
}
