<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use DB2;
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
use NumeroALetras;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    public function pdfRecibo(Recibo_Maestro $id)
    {
        //$recibo = Recibo_Maestro::where('numero_recibo')->first();
        $query = "SELECT numero_recibo FROM sigecig_recibo_maestro ORDER BY numero_recibo desc ";
        $result = DB::select($query);
        $recibo = $result[0]->numero_recibo;

        $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaRecibo/'.$id->numero_recibo); //link para colegiados
        // $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaReciboGeneral/'.$id->numero_recibo); //link para Particulares
        // $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaReciboEmpresa/'.$id->numero_recibo); //link para Empresa

        $nit_ = SQLSRV_Colegiado::where("c_cliente",$id->numero_de_identificacion)->get()->first();
        $letras = NumeroALetras::convertir($id->monto_total, 'QUETZALES', 'CENTAVOS');
        $query1= "SELECT rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
        FROM sigecig_recibo_detalle rd
        INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
        WHERE rd.numero_recibo = $id->numero_recibo";
        $datos = DB::select($query1);

       return \PDF::loadView('admin.creacionRecibo.pdfrecibo', compact('id', 'nit_', 'letras', 'datos', 'codigoQR'))
        ->setPaper('legal', 'landscape')
        ->stream('Recibo.pdf');
    }

    public function SerieDePagoA($id)
    {
        $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 3)->orWhere('categoria_id', '=', 6)->get();
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
        // $consulta= SQLSRV_Colegiado::select('n_cliente', 'estado', 'f_ult_timbre', 'f_ult_pago', 'monto_timbre', 'fallecido')
        //     ->where('c_cliente', $colegiado)->get()->first();

        $query = "SELECT n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                  WHERE c_cliente = $colegiado AND DATEDIFF(month, f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, f_ult_timbre, GETDATE()) <= 3";
        $result = DB::connection('sqlsrv')->select($query);

        if (!empty($result)){
            $result[0]->estado='Activo';
            return $result;
        }else {
            $query = "SELECT n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                  WHERE c_cliente = $colegiado AND DATEDIFF(month, f_ult_pago, GETDATE()) > 3 and DATEDIFF(month, f_ult_timbre, GETDATE()) > 3";
            $resultado = DB::connection('sqlsrv')->select($query);
            $resultado[0]->estado='Inactivo';

            // $igual = [
            //     0=>['n_cliente'=> $resultado[0]->n_cliente, 'estado' => 'Inactivo', 'f_ult_timbre'=> $resultado[0]->f_ult_timbre,
            //         'f_ult_pago'=> $resultado[0]->f_ult_pago, 'monto_timbre'=> $resultado[0]->monto_timbre, 'fallecido'=> $resultado[0]->fallecido,]
            // ];

            return $resultado;

        }
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
            ->where('id', $tipo)->where('estado', '=', 0)->get()->first();

            return $consulta;
    }

    public function getTipoDePagoB($tipo)
    {
        $consulta= TipoDePago::select('codigo', 'tipo_de_pago', 'precio_colegiado', 'precio_particular', 'categoria_id')
            ->where('id', $tipo)->where('estado', '=', 0)->where('categoria_id', '!=', 3)->get()->first();

            return $consulta;
    }

    public function getDatosReactivacion()
    {
        return view('admin.creacionRecibo.interes');
    }
    //   ----------------------------------------> datos de reactivacion <----------------------------------------
    public function getMontoReactivacion()
    {
        $fecha_timbre = Input::get('fecha_timbre', date("Y-m-t"));
        $fecha_colegio = Input::get('fecha_colegio', date("Y-m-t"));
        $colegiado = Input::get('colegiado');
        $fecha_hasta_donde_paga = Input::get('fecha_hasta_donde_paga', date("Y-m-t"));
        $monto_timbre = Input::get('monto_timbre', 0);
        if (!$fecha_timbre || !$fecha_hasta_donde_paga || !$monto_timbre) {
            return json_encode(array("capital" => 0, "mora" => 0, "interes" => 0, "total" => 0));
        }
        $reactivacion = [];
        $reactivacionColegio = $this->getMontoReactivacionColegio($fecha_colegio,$fecha_hasta_donde_paga, $colegiado);
        $reactivacionTimbre = $this->getMontoReactivacionTimbre($fecha_timbre, $fecha_hasta_donde_paga, $monto_timbre, Input::get('exonerar_intereses_timbre'));
        $reactivacion['capitalTimbre'] = $reactivacionTimbre['capital'];
        $reactivacion['moraTimbre'] = $reactivacionTimbre['mora'];
        $reactivacion['interesTimbre'] = $reactivacionTimbre['interes'];
        $reactivacion['totalTimbre'] = $reactivacionTimbre['total'];
        $reactivacion['cuotasTimbre'] = $reactivacionTimbre['cuotas_timbre'];
        $reactivacion['cuotasColegio'] = $reactivacionColegio['cuotas'];
        $reactivacion['interesColegio'] = $reactivacionColegio['montoInteres'];
        $reactivacion['capitalColegio'] = $reactivacionColegio['capitalColegio'];
        $reactivacion['totalColegio'] = $reactivacionColegio['totalColegio'];
        $reactivacion['total'] = $reactivacionTimbre['total'] + $reactivacionColegio['totalColegio'];
        return json_encode($reactivacion);
    }

    private function getMontoReactivacionTimbre($fecha_timbre, $fecha_hasta_donde_paga, $monto_timbre, $exonerar_intereses_timbre)
    {
        //dd($fecha_timbre);
        //$mes_origen = date("m", strtotime($fecha_timbre));
        $mes_origen = substr($fecha_timbre, -7,2);
        //$anio_origen = date("Y", strtotime($fecha_timbre));
        $anio_origen = substr($fecha_timbre, -4);
        //dd($mes_origen);
        $mes_fin = date("m", strtotime($fecha_hasta_donde_paga));
        $anio_fin = date("Y", strtotime($fecha_hasta_donde_paga));

        $fecha_fin_meses = $mes_fin + $anio_fin * 12;
        $fecha_origen_meses = $mes_origen + $anio_origen * 12;
        $cuotas_timbre = $fecha_fin_meses - $fecha_origen_meses;

        $mes_actual = date("m");
        $anio_actual = date("Y");

        $fecha_actual_meses = $mes_actual + $anio_actual * 12;

        $monto_extra = 0;
        if ($fecha_fin_meses <= $fecha_actual_meses) {
            $diferencia = $fecha_fin_meses - $fecha_origen_meses;
            if ($diferencia <= 3) {
                $diferencia = 0;
            }
        } else {
            $diferencia = $fecha_actual_meses - $fecha_origen_meses;
            if ($diferencia <= 3) {
                $diferencia = 0;
            }
            $monto_extra = $fecha_fin_meses - $fecha_actual_meses;
        }

        $capital = round($monto_timbre * ($anio_fin*12+$mes_fin - ($anio_origen*12 + $mes_origen)));
        $mora = round($monto_timbre * 0.18 / 12 * $diferencia * ($diferencia - 1) / 2);
        $intereses = round($monto_timbre * 0.128 / 12 * $diferencia * ($diferencia - 1) / 2);
        if($exonerar_intereses_timbre == 1) {
            $mora = 0;
            $intereses = 0;
        }
        $total = $capital + $mora + $intereses;

        return array("capital" => $capital, "mora" => $mora, "interes" => $intereses, "total" => $total, 'cuotas_timbre' => $cuotas_timbre);
    }

    public function getMontoReactivacionColegio($fecha_colegio, $fecha_hasta_donde_paga = null, $colegiado)
    {
        $fechaHasta = $fecha_hasta_donde_paga ? $fecha_hasta_donde_paga : date('Y-m-d');
        $fechaHastaT = strtotime($fechaHasta);
        $fechaFinMes = strtotime(date('Y-m-t',strtotime(date('Y') . '-' . (date('m')-3) . '-01')));
        $fechaTope = $fechaHastaT;
        if ($fechaHastaT > $fechaFinMes) {
            $fechaTope = $fechaFinMes;
        }

        $fechaultimopagocolegio = $fecha_colegio;

        $fechaDesdeT = strtotime($fechaultimopagocolegio);
        $cuotas = date('Y', $fechaTope) * 12 + date('m', $fechaTope) - (date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT));
        $cuotasD = date('Y', $fechaHastaT) * 12 + date('m', $fechaHastaT) - (date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT));
        $d =$cuotasD-$cuotas;
        $porcentajeInteres = 8.5;
        $montoBase = 40.75;
        $montoInteresAtrasado = 0;
        if ($cuotas > 0) {
            //$montoInteresAtrasado = $this->calculoPotenciaColegio($cuotas, $porcentajeInteres, $montoBase);
        }

        $mesesTemp = date('Y', $fechaHastaT) * 12 + date('m', $fechaHastaT);
        $mesesDesdeTemp = date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT);
        $cuotasTemp = $mesesDesdeTemp - $mesesTemp;
        $mesesAnterior = 1983*12+2;
        $montoAnterior = 6;
        $totalMontoColegio = 0;

        $montosPago = [['meses' => 1983*12+2, 'monto' => 6, 'codigo' => 'COL01', 'auxilio' => 0], ['meses' => 1989*12+12, 'monto' => 12, 'codigo' => 'COL02', 'auxilio' => 6],['meses' => 1990*12+12, 'monto' => 23.25, 'codigo' => 'COL03', 'auxilio' => 12.75], ['meses' => 1991*12+9, 'monto' => 30, 'codigo' => 'COL04', 'auxilio' => 12.75], ['meses' => 2001*12 + 9, 'monto' => 39, 'codigo' => 'COL05', 'auxilio' => 12.75], ['meses' => 2001*12 + 12, 'monto' => 60, 'codigo' => 'COL06', 'auxilio' => 22.75], ['meses' => 2010*12 + 10, 'monto' => 65, 'codigo' => 'COL07', 'auxilio' => 22.75], ['meses' => 2011*12 + 8, 'monto' => 78.5, 'codigo' => 'COL08', 'auxilio' => 22.75], ['meses' => 2013*12 + 1, 'monto' => 98.5, 'codigo' => 'COL091', 'auxilio' => 22.75], ['meses' => date('Y')*12 + date('m'), 'monto' => 115.75, 'codigo' => 'COL092', 'auxilio' => 40.75]];
        $detalleMontos = [];
        $montoInteresAtrasado = 0;
        foreach($montosPago as $montoPago) {

            if($mesesDesdeTemp <= $montoPago['meses']) {
                $diferencia = $montoPago['meses'] - $mesesDesdeTemp >= 0 ? $montoPago['meses'] - $mesesDesdeTemp : 0;
                $dif2 = $mesesTemp - $mesesDesdeTemp;
                if($montoPago['monto']==115.75){$diferencia+=$d;}


                $totalMontoColegio += $diferencia * $montoPago['monto'];
                $cuotasTemp -= $diferencia;
                $mesesDesdeTemp = $montoPago['meses'];
                $detalleMontos[] = ['codigo' => $montoPago['codigo'], 'cuotas' => $diferencia, 'preciou' => $montoPago['monto']];
                $montoInteresAtrasado += $this->calculoPotenciaColegio($diferencia, $porcentajeInteres, $montoPago['auxilio'], $dif2);
            }

        }

        $query = "select importe from calculo_colegiado(".$colegiado.", '".$fecha_hasta_donde_paga."','02', '".date('Y-m-d')."') WHERE codigo='INT'";

        $users = DB::connection('sqlsrv')->select($query);
        $colegiadoR = null;
        foreach ($users as $colegiado1) {
            $colegiadoR = $colegiado1;
        }
        $inte = 0;
        if($colegiadoR){
            $inte = $colegiadoR->importe;
	    }


        $query = "select * from calculo_colegiado(".$colegiado.", '".$fecha_hasta_donde_paga."','02', '".date('Y-m-d')."') WHERE codigo!='INT'";

        $users = DB::connection('sqlsrv')->select($query);
        $colegiadoR1 = null;
        $detalleMontos = [];
        $capitalT = 0;
        foreach ($users as $colegiado2) {
            $colegiadoR = $colegiado2;
        $detalleMontos[] = ['codigo' => $colegiado2->codigo, 'cuotas' => $colegiado2->cantidad, 'preciou' => $colegiado2->precio];
        $capitalT += $colegiado2->cantidad*$colegiado2->precio;
        }

        $totalMontoColegio += ($mesesTemp - ($mesesDesdeTemp > 0 ? $mesesDesdeTemp : 0)) * 115.75;
        $total = $totalMontoColegio + $montoInteresAtrasado;
        $total = $capitalT + $inte;

        return array("montoInteres" => round($inte, 2), "cuotas" => $cuotasD, 'capitalColegio' => $capitalT, 'totalColegio' => round($total,2), 'detalleMontos' => $detalleMontos);
    //        return array("montoInteres" => round($inte, 2), "cuotas" => $cuotasD, 'capitalColegio' => $totalMontoColegio, 'totalColegio' => round($total,2), 'detalleMontos' => $detalleMontos);
    }

    private function calculoPotenciaColegio($cuotasAtrasadas, $porcentajeInteres, $montoBase, $dif2)
    {
        $suma = 0;
        for ($i = 1; $i < $cuotasAtrasadas + 1; $i++) {
            $suma += pow(1 + $porcentajeInteres / 1000, $dif2-$i);
        }
        $suma = $montoBase * ($suma - $cuotasAtrasadas);
        return $suma;
    }
}




