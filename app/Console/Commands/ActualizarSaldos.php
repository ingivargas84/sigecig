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
        $mesActual = Now()->format('m');
        $anioActual = Now()->format('yy');
        $mesAnterior=Carbon::Now()->startOfMonth()->subMonth();
        $mes=$mesAnterior->format('m');
        $anio=$mesAnterior->format('yy');
        $ageFrom=Carbon::Now()->startOfMonth()->subMonth();
        $ageTo=Carbon::Now()->startOfMonth()->subSecond();
      
        $cuenta = \App\EstadoDeCuentaMaestro::orderBy("colegiado_id", "asc")->get();
        foreach ($cuenta as $key => $value) {
            $saldoActual =\App\SigecigSaldoColegiados::where('no_colegiado',$value->colegiado_id)->where('mes_id',$mes)->where('año',$anio)->get()->last();
            $abono=\App\EstadoDeCuentaDetalle::where('estado_cuenta_maestro_id',$value->id)->whereBetween('updated_at', [$ageFrom, $ageTo])->sum('abono');
            if(empty($abono)){
                $abono=0;
            }
            $cargo=\App\EstadoDeCuentaDetalle::where('estado_cuenta_maestro_id',$value->id)->whereBetween('updated_at', [$ageFrom, $ageTo])->sum('cargo');
            if(empty($cargo)){
                $cargo=0;
            }
            if(empty($saldoActual)){
                $total = $cargo-$abono;
            }else{
            $total = $saldoActual->saldo+$cargo-$abono;
              }  
            $saldos = \App\SigecigSaldoColegiados::create([
                'no_colegiado'      => $value->colegiado_id,
                'mes_id'            => $mesActual,
                'año'               => $anioActual,
                'saldo'             => $total,
                'fecha'             => Now(),
            ]);
        }
 
    }
}
