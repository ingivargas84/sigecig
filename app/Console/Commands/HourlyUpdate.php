<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PlataformaBanco;


class HourlyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cuota Colegiado + Cuota Mensual';

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
        $bco->nombre_banco="Desde Crob job";
        $bco->save();
    }
}
