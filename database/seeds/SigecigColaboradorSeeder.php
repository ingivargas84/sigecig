<?php

use Illuminate\Database\Seeder;
use App\Colaborador;

class SigecigColaboradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colaborador=new Colaborador();
        $colaborador->nombre="elias_cajero";
        $colaborador->dpi='2545303112208';
        $colaborador->departamento_dpi_id=12;
        $colaborador->municipio_dpi_id=89;
        $colaborador->puesto=11;
        $colaborador->departamento=7;
        $colaborador->subsede=1;
        $colaborador->telefono="45454545";
        $colaborador->usuario=3;
        $colaborador->estado=1;
        $colaborador->save();

    }
}
