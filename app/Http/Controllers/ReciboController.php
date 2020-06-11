<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\SQLSRV_Colegiado;
use App\SQLSRV_Empresa;
use App\TipoDePago;
use App\User;
use App\Recibo_Maestro;
use App\Recibo_Detalle;
use App\SerieRecibo;
use App\ReciboCheque;
use App\ReciboTarjeta;
use App\PosCobro;
use Validator;

class ReciboController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $tipo = TipoDePago::where('estado', '=', 0)->get(); //el estado "0" son los tipo de pago activos
        // return view('admin.creacionRecibo.index', compact('tipo'));
        $pos = PosCobro::all();
        return view('admin.creacionRecibo.index', compact('pos'));
    }

    public function SerieDePagoA($id)
    {
        $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 3)->get();
        return json_encode($tipo);
    }

    public function SerieDePagoB($id)
    {
        $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '!=', 3)->get();
        return json_encode($tipo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // almacen de datos de COLEGIADO
        //dd($request);
        $serieRecibo        = $request->input("config.tipoSerieRecibo");
        $tipoDeCliente      = $request->input("config.tipoDeCliente");
        $colegiado          = $request->input("config.c_cliente");
        $nombreCliente      = $request->input("config.n_cliente");
        $estado             = $request->input("config.estado");
        $complemento        = $request->input("config.complemento");
        $ultPagoTimbre      = $request->input("config.f_ult_timbre");
        $ulPagoColegio      = $request->input("config.f_ult_pago");
        $montoTimbre        = $request->input("config.monto_timbre");
        $totalAPagar        = $request->input("config.total");
        $pagoEnEfectivo     = $request->input("config.pagoEfectivo");
        $montoefectivo      = $request->input("config.montoefectivo");
        $pagoCheque         = $request->input("config.pagoCheque");
        $numeroCheque       = $request->input("config.cheque");
        $montoCheque        = $request->input("config.montoCheque");
        $pagoTarjeta        = $request->input("config.pagoTarjeta");
        $numeroTarjeta      = $request->input("config.tarjeta");
        $montoTarjeta       = $request->input("config.montoTarjeta");
        $pos_id             = $request->input("pos");

            $tipoDeCliente = 1;
            if($serieRecibo == 'a'){
                $serieRecibo = 1;
            }elseif($serieRecibo == 'b'){
                $serieRecibo = 2;
            }

        //$lastValue = DB::table('sigecig_recibo_maestro')->orderBy('numero_recibo', 'desc')->first();
        $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();

        $reciboMaestro = new Recibo_Maestro;
        $reciboMaestro->serie_recibo_id = $serieRecibo;
        //$reciboMaestro->numero_recibo =  $lastValue->numero_recibo + 1;
        $reciboMaestro->numero_recibo =  $lastValue + 1;
        $reciboMaestro->numero_de_identificacion = $colegiado;
        $reciboMaestro->nombre = $nombreCliente;
        $reciboMaestro->tipo_de_cliente_id = $tipoDeCliente;
        $reciboMaestro->complemento = $complemento;
        $reciboMaestro->monto_efecectivo = $montoefectivo;
        $reciboMaestro->monto_tarjeta = $montoTarjeta;
        $reciboMaestro->monto_cheque = $montoCheque;
        $reciboMaestro->usuario = Auth::user()->id;
        $reciboMaestro->monto_total = $totalAPagar;
        $reciboMaestro->save();

        $array = $request->input("datos");

        for ($i = 1; $i < sizeof($array); $i++){
            $reciboDetalle = Recibo_Detalle::create([
                'numero_recibo'     => $reciboMaestro->numero_recibo,
                'codigo_compra'     => $array[$i][1],
                'cantidad'          => $array[$i][2],
                'precio_unitario'   => $array[$i][3],
                'total'             => $array[$i][5],
            ]);
        }

        if ($pagoCheque == 'si'){
            $bdCheque = new ReciboCheque;
            $bdCheque->numero_recibo = $reciboMaestro->numero_recibo;
            $bdCheque->numero_cheque = $numeroCheque;
            $bdCheque->monto = $montoCheque;
            $bdCheque->nombre_banco = "";
            $bdCheque->usuario_id = Auth::user()->id;
            $bdCheque->fecha_de_cheque = now();
            $bdCheque->save();
        }

        if ($pagoTarjeta == 'si'){
            $bdTarjeta = new ReciboTarjeta;
            $bdTarjeta->numero_recibo = $reciboMaestro->numero_recibo;
            $bdTarjeta->numero_voucher = $numeroTarjeta;
            $bdTarjeta->monto = $montoTarjeta;
            $bdTarjeta->pos_cobro_id = $pos_id;
            $bdTarjeta->usuario_id = Auth::user()->id;
            $bdTarjeta->save();
        }

        return response()->json(['success' => 'Exito']);


    }

    public function storeParticular(Request $request)
    {
        // almacen de datos de PARTICULAR

        $serieReciboP        = $request->input("config.tipoSerieReciboP");
        $tipoDeCliente       = $request->input("config.tipoDeCliente");
        $dpi                 = $request->input("config.dpi");
        $nombreClienteP      = $request->input("config.nombreP");
        $totalAPagarP        = $request->input("config.totalP");
        $pagoEnEfectivoP     = $request->input("config.pagoEfectivoP");
        $montoefectivoP      = $request->input("config.montoefectivoP");
        $pagoChequeP         = $request->input("config.pagoChequeP");
        $numeroChequeP       = $request->input("config.chequeP");
        $montoChequeP        = $request->input("config.montoChequeP");
        $pagoTarjetaP        = $request->input("config.pagoTarjetaP");
        $numeroTarjetaP      = $request->input("config.tarjetaP");
        $montoTarjetaP       = $request->input("config.montoTarjetaP");
        $pos_idP             = $request->input("pos");

            $tipoDeCliente = 2;
            if($serieReciboP == 'a'){
                $serieReciboP = 1;
            }elseif($serieReciboP == 'b'){
                $serieReciboP = 2;
            }

            $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();

        $reciboMaestroP = new Recibo_Maestro;
        $reciboMaestroP->serie_recibo_id = $serieReciboP;
        $reciboMaestroP->numero_recibo =  $lastValue + 1;
        $reciboMaestroP->numero_de_identificacion = $dpi;
        $reciboMaestroP->nombre = $nombreClienteP;
        $reciboMaestroP->tipo_de_cliente_id = $tipoDeCliente;
        $reciboMaestroP->complemento = " ";
        $reciboMaestroP->monto_efecectivo = $montoefectivoP;
        $reciboMaestroP->monto_tarjeta = $montoTarjetaP;
        $reciboMaestroP->monto_cheque = $montoChequeP;
        $reciboMaestroP->usuario = Auth::user()->id;
        $reciboMaestroP->monto_total = $totalAPagarP;
        $reciboMaestroP->save();

        $array = $request->input("datos");

        for ($i = 1; $i < sizeof($array); $i++){
            $reciboDetalleP = Recibo_Detalle::create([
                'numero_recibo'     => $reciboMaestroP->numero_recibo,
                'codigo_compra'     => $array[$i][1],
                'cantidad'          => $array[$i][2],
                'precio_unitario'   => $array[$i][3],
                'total'             => $array[$i][5],
            ]);
        }

        if ($pagoChequeP == 'si'){
            $bdChequeP = new ReciboCheque;
            $bdChequeP->numero_recibo = $reciboMaestroP->numero_recibo;
            $bdChequeP->numero_cheque = $numeroChequeP;
            $bdChequeP->monto = $montoChequeP;
            $bdChequeP->nombre_banco = "";
            $bdChequeP->usuario_id = Auth::user()->id;
            $bdChequeP->fecha_de_cheque = now();
            $bdChequeP->save();
        }

        if ($pagoTarjetaP == 'si'){
            $bdTarjetaP = new ReciboTarjeta;
            $bdTarjetaP->numero_recibo = $reciboMaestroP->numero_recibo;
            $bdTarjetaP->numero_voucher = $numeroTarjetaP;
            $bdTarjetaP->monto = $montoTarjetaP;
            $bdTarjetaP->pos_cobro_id = $pos_idP;
            $bdTarjetaP->usuario_id = Auth::user()->id;
            $bdTarjetaP->save();
        }

        return response()->json(['success' => 'Exito']);
    }

    public function storeEmpresa(Request $request)
    {
        // almacen de datos de EMPRESA

        $serieReciboE        = $request->input("config.tipoSerieReciboE");
        $tipoDeCliente       = $request->input("config.tipoDeCliente");
        $nit                 = $request->input("config.nit");
        $empresa             = $request->input("config.empresa");
        $totalAPagarE        = $request->input("config.totalE");
        $pagoEnEfectivoE     = $request->input("config.pagoEfectivoE");
        $montoefectivoE      = $request->input("config.montoefectivoE");
        $pagoChequeE         = $request->input("config.pagoChequeE");
        $numeroChequeE       = $request->input("config.chequeE");
        $montoChequeE        = $request->input("config.montoChequeE");
        $pagoTarjetaE        = $request->input("config.pagoTarjetaE");
        $numeroTarjetaE      = $request->input("config.tarjetaE");
        $montoTarjetaE       = $request->input("config.montoTarjetaE");
        $pos_idE             = $request->input("pos");

            $tipoDeCliente = 3;
            if($serieReciboE == 'a'){
                $serieReciboE = 1;
            }elseif($serieReciboE == 'b'){
                $serieReciboE = 2;
            }

            $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();

        $reciboMaestroE = new Recibo_Maestro;
        $reciboMaestroE->serie_recibo_id = $serieReciboE;
        $reciboMaestroE->numero_recibo =  $lastValue + 1;
        $reciboMaestroE->numero_de_identificacion = $nit;
        $reciboMaestroE->nombre = $empresa;
        $reciboMaestroE->tipo_de_cliente_id = $tipoDeCliente;
        $reciboMaestroE->complemento = " ";
        $reciboMaestroE->monto_efecectivo = $montoefectivoE;
        $reciboMaestroE->monto_tarjeta = $montoTarjetaE;
        $reciboMaestroE->monto_cheque = $montoChequeE;
        $reciboMaestroE->usuario = Auth::user()->id;
        $reciboMaestroE->monto_total = $totalAPagarE;
        $reciboMaestroE->save();

        $array = $request->input("datos");

        for ($i = 1; $i < sizeof($array); $i++){
            $reciboDetalleE = Recibo_Detalle::create([
                'numero_recibo'     => $reciboMaestroE->numero_recibo,
                'codigo_compra'     => $array[$i][1],
                'cantidad'          => $array[$i][2],
                'precio_unitario'   => $array[$i][3],
                'total'             => $array[$i][5],
            ]);
        }

        if ($pagoChequeE == 'si'){
            $bdChequeE = new ReciboCheque;
            $bdChequeE->numero_recibo = $reciboMaestroE->numero_recibo;
            $bdChequeE->numero_cheque = $numeroChequeE;
            $bdChequeE->monto = $montoChequeE;
            $bdChequeE->nombre_banco = "";
            $bdChequeE->usuario_id = Auth::user()->id;
            $bdChequeE->fecha_de_cheque = now();
            $bdChequeE->save();
        }

        if ($pagoTarjetaE == 'si'){
            $bdTarjetaE = new ReciboTarjeta;
            $bdTarjetaE->numero_recibo = $reciboMaestroE->numero_recibo;
            $bdTarjetaE->numero_voucher = $numeroTarjetaE;
            $bdTarjetaE->monto = $montoTarjetaE;
            $bdTarjetaE->pos_cobro_id = $pos_idE;
            $bdTarjetaE->usuario_id = Auth::user()->id;
            $bdTarjetaE->save();
        }

        return response()->json(['success' => 'Exito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDatosColegiado($colegiado)
    {
        $consulta= SQLSRV_Colegiado::select('n_cliente', 'estado', 'f_ult_timbre', 'f_ult_pago', 'monto_timbre')
            ->where('c_cliente', $colegiado)->get()->first();

        return $consulta;
        //dd($consulta);
    }

    public function getDatosEmpresa($nit)
    {
        $consulta= SQLSRV_Empresa::select('empresa')
            ->where('nit', $nit)->get()->first();

        return $consulta;
    }

    public function getTipoDePagoA($tipo)
    {
        $consulta= TipoDePago::select('codigo', 'tipo_de_pago', 'precio_colegiado', 'precio_particular', 'categoria_id')
            ->where('id', $tipo)->where('estado', '=', 0)->where('categoria_id', '=', 3)->get()->first();

            return $consulta;
    }

    public function getTipoDePagoB($tipo)
    {
        $consulta= TipoDePago::select('codigo', 'tipo_de_pago', 'precio_colegiado', 'precio_particular', 'categoria_id')
            ->where('id', $tipo)->where('estado', '=', 0)->where('categoria_id', '!=', 3)->get()->first();

            return $consulta;
    }
}
