<?php

use Illuminate\Database\Seeder;
use App\PlataformaTipoCuenta;

class PlataformaTipoCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cta=new PlataformaTipoCuenta();
        $cta->tipo_cuenta="Monetaria";
        $cta->save();

        $cta=new PlataformaTipoCuenta();
        $cta->tipo_cuenta="Ahorro";
        $cta->save();
    }
}
