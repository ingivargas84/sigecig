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

        //$this->call(TiposLocalidadesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');        
    }
}
