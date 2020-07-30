<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PlataformaBanco;


class ActualizarSaldos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saldos:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizacion de Saldos Mensual de Colegiados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {  
        $bco=new PlataformaBanco();
        $bco->nombre_banco="A la 12.30 desde Actualizacion Saldos";
        $bco->save();
    }
}
