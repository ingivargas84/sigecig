<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UsersSeeder::class);
        $this->call(NegocioSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(EstadoBoletaSeeder::class);
        $this->call(EstadoProcesoBoletaSeeder::class);
        $this->call(EstadoSolicitudSeeder::class);
        $this->call(PuestoSeeder::class);
        $this->call(EstadoSolicitudApSeeder::class);
        $this->call(CategoriaTipoPagoSeeder::class);
        $this->call(PlataformaBancoSeeder::class);
        $this->call(PlataformaTipoCuentaSeeder::class);
        $this->call(PosCobroSeeder::class);
        $this->call(TipoDeClienteSeeder::class);
        $this->call(SerieReciboSeeder::class);
        $this->call(TipoDePagoSeeder::class);
        $this->call(CreacionSolicitudSeeder::class);
        $this->call(EstadoDeEstadosDeCuentaSeeder::class);
        $this->call(bodegaDetalleSeeder::class);
        $this->call(SegecigMesesSeeder::class);


        //$this->call(TiposLocalidadesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
