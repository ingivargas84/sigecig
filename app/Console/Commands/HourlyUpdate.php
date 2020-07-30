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
        // $cuenta = \App\EstadoDeCuentaMaestro::orderBy("colegiado_id", "asc")->get();
        // $servicio = \App\TipoDePago::where('id','11')->get()->first();
        // $timbre = \App\TipoDePago::where('id','23')->get()->first();
        // foreach ($cuenta as $key => $value) {
        //     $colegiado=\App\SQLSRV_Colegiado::where('c_cliente',$value->colegiado_id)->get()->first();
        //     $timbres = $colegiado->codigosTimbrePago('1');
        //     $cuentaD = \App\EstadoDeCuentaDetalle::create([
        //         'estado_cuenta_maestro_id'      => $value->id,
        //         'cantidad'                      => '1',
        //         'tipo_pago_id'                  => $servicio->id,
        //         'recibo_id'                     => '1',
        //         'abono'                         => '0.00',
        //         'cargo'                         => $servicio->precio_colegiado,
        //         'usuario_id'                    => '1',
        //         'estado_id'                     => '1',
        //     ]);
        //     foreach ($timbres as $key => $timbre) {
        //         $timbreColegiado = \App\EstadoDeCuentaDetalle::create([
        //             'estado_cuenta_maestro_id'      => $value->id,
        //             'cantidad'                      => $timbre->cantidad,
        //             'tipo_pago_id'                  => $timbre->id,
        //             'recibo_id'                     => '1',
        //             'abono'                         => '0.00',
        //             'cargo'                         => $timbre->total,
        //             'usuario_id'                    => '1',
        //             'estado_id'                     => '1',
        //         ]);
        //     }

         

        // }
    }
}
