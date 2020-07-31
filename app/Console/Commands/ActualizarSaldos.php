<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PlataformaBanco;
use Carbon\Carbon;



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
        $mes = Now()->format('m');
        $anio = Now()->format('yy');
        $cuenta = \App\EstadoDeCuentaMaestro::orderBy("colegiado_id", "asc")->get();
        foreach ($cuenta as $key => $value) {
            $abono=\App\EstadoDeCuentaDetalle::where('estado_cuenta_maestro_id',$value->id)->sum('abono');
            $cargo=\App\EstadoDeCuentaDetalle::where('estado_cuenta_maestro_id',$value->id)->sum('cargo');
            $total = $cargo-$abono;
            $saldos = \App\SigecigSaldoColegiados::create([
                'no_colegiado'      => $value->colegiado_id,
                'mes_id'            => $mes,
                'año'               => $anio,
                'saldo'             => $total,
                'fecha'             => Now(),
            ]);
        }
 
    }
}
