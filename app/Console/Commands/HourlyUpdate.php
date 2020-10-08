<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PlataformaBanco;
use Carbon\Carbon;



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
        $cuenta = \App\EstadoDeCuentaMaestro::orderBy("colegiado_id", "asc")->get();
        $servicio = \App\TipoDePago::where('id','11')->get()->first();
        $timbre = \App\TipoDePago::where('id','62')->get()->first();
        $fecha_actual = Carbon::now()->endOfMonth();


        foreach ($cuenta as $key => $value) {
            $colegiado=\App\SQLSRV_Colegiado::where('c_cliente',$value->colegiado_id)->get()->first();
            $timbre->precio_colegiado = $colegiado->monto_timbre;
            $interesColegiado = $colegiado->getMontoReactivacionMensual(); 
            $interesColegiado[] = $servicio;
            $interesColegiado[] = $timbre;

            foreach ($interesColegiado as $key => $pagos) {
                $cuentaD = \App\EstadoDeCuentaDetalle::create([
                    'estado_cuenta_maestro_id'      => $value->id,
                    'cantidad'                      => '1',
                    'tipo_pago_id'                  => $pagos->id,
                    'recibo_id'                     => '1',
                    'abono'                         => '0.00',
                    'cargo'                         => $pagos->precio_colegiado,
                    'usuario_id'                    => '1',
                    'estado_id'                     => '1',
                ]);
            }
            

        }
    }
}
