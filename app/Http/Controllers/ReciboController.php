<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB, Mail;
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
use App\Aspirante;
use App\Recibo_Maestro;
use App\Recibo_Detalle;
use App\ReciboAspirante;
use App\SerieRecibo;
use App\ReciboCheque;
use App\ReciboTarjeta;
use App\ReciboDeposito;
use App\PosCobro;
use App\Banco;
use App\SigecigMeses;
use App\VentaDeTimbres;
use App\TiposDeProductos;
use App\IngresoProducto;
use Validator;
// use NumeroALetras;
use Luecano\NumeroALetras\NumeroALetras;
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
        $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 1)->where('id', '!=', '30')->where('id', '!=', '31')
                            ->where('id', '!=', '32')->where('id', '!=', '33')->where('id', '!=', '34')
                            ->where('id', '!=', '35')->where('id', '!=', '36')->where('id', '!=', '37')
                            ->where('id', '!=', '38')->where('id', '!=', '39')
                            ->where('id', '!=', '40')->where('id', '!=', '41')->where('id', '!=', '42')
                            ->where('id', '!=', '43')->where('id', '!=', '44')->where('id', '!=', '45')
                            ->orWhere('categoria_id', '=', 6)->orWhere('categoria_id', '=', 7)->get(); //el estado "0" son los tipo de pago activos
        $pos = PosCobro::all();
        $banco = Banco::all();
        return view('admin.creacionRecibo.index', compact('pos', 'tipo', 'banco'));
    }

    public function pdfRecibo(Recibo_Maestro $id)
    {
        // $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaRecibo/' . $id->numero_recibo); //link para colegiados
        $codigoQR = QrCode::format('png')->size(100)->generate('http://58995697bbcf.ngrok.io/constanciaRecibo/' . $id->numero_recibo); //link para colegiados version prueba
        // $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaReciboGeneral/'.$id->numero_recibo); //link para Particulares y Empresa
        $letras = new NumeroALetras;
        $letras->toMoney($id->monto_total, 2, 'QUETZALES', 'CENTAVOS');
        $nit_ = SQLSRV_Colegiado::where("c_cliente", $id->numero_de_identificacion)->get()->first();
        $query1= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total, tp.categoria_id, rd.id_mes, rd.año
        FROM sigecig_recibo_detalle rd
        INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
        WHERE rd.numero_recibo = $id->numero_recibo";
        $datos = DB::select($query1);

        foreach ($datos as $key => $dato) {
            if ($dato->categoria_id == 1) {
                $dato->tipo_de_pago = $dato->tipo_de_pago.' No.';
                $numeroTimbres = \App\VentaDeTimbres::where('recibo_detalle_id',$dato->id)->get();
                $tamanioArrray =count($numeroTimbres) -1;
                foreach ($numeroTimbres as $key => $numeroTimbre) {
                    if ($dato->cantidad == 1) {
                        $dato->tipo_de_pago = $dato->tipo_de_pago.' '.$numeroTimbre->numeracion_inicial;
                    }else{
                        $dato->tipo_de_pago = $dato->tipo_de_pago.' '.$numeroTimbre->numeracion_inicial.'-'.$numeroTimbre->numeracion_final;
                    }
                    if ($key < $tamanioArrray) {
                        $dato->tipo_de_pago = $dato->tipo_de_pago.',';
                    }
                }
            }
        }

        foreach ($datos as $key => $dato) {
            if ($dato->codigo_compra == 'COL092') {
                $meses = SigecigMeses::select('mes')->where('id',$dato->id_mes)->get();
                foreach ($meses as $key => $meses) {
                    $dato->tipo_de_pago = $dato->tipo_de_pago.' ('.$meses->mes.' '.$dato->año.')';
                }
            }
        }

       return \PDF::loadView('admin.creacionRecibo.pdfrecibo', compact('id', 'nit_', 'letras', 'datos', 'codigoQR'))
        ->setPaper('legal', 'landscape')
        ->stream('Recibo.pdf');
    }

    public function SerieDePagoA(Request $request)
    {
        $cliente = $request->datoSelected;
        if ($cliente == 'c'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '!=', 1)->get();
            return json_encode($tipo);
        }
        if ($cliente == 'e'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '!=', 1)->get();
            return json_encode($tipo);
        }
        if ($cliente == 'p'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '!=', 1)->where('categoria_id', '!=', 3)->get();
            return json_encode($tipo);
        }

    }

    public function SerieDePagoB(Request $request)
    {
        $cliente = $request->datoSelected;
        if ($cliente == 'c'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 1)->where('id', '!=', '30')->where('id', '!=', '31')
                            ->where('id', '!=', '32')->where('id', '!=', '33')->where('id', '!=', '34')
                            ->where('id', '!=', '35')->where('id', '!=', '36')->where('id', '!=', '37')
                            ->where('id', '!=', '38')->where('id', '!=', '39')
                            ->where('id', '!=', '40')->where('id', '!=', '41')->where('id', '!=', '42')
                            ->where('id', '!=', '43')->where('id', '!=', '44')->where('id', '!=', '45')
                            ->orWhere('categoria_id', '=', 6)->orWhere('categoria_id', '=', 7)->get(); //el estado "0" son los tipo de pago activos
            return json_encode($tipo);
        }
        if ($cliente == 'e'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 1)->where('id', '!=', '22')->where('id', '!=', '23')
                            ->where('id', '!=', '24')->where('id', '!=', '25')->where('id', '!=', '26')
                            ->where('id', '!=', '27')->where('id', '!=', '28')->where('id', '!=', '29')
                            ->where('id', '!=', '30')->where('id', '!=', '31')
                            ->where('id', '!=', '32')->where('id', '!=', '33')->where('id', '!=', '34')
                            ->where('id', '!=', '35')->where('id', '!=', '36')->where('id', '!=', '37')
                            ->orWhere('categoria_id', '=', 6)->orWhere('categoria_id', '=', 7)->get(); //el estado "0" son los tipo de pago activos
            return json_encode($tipo);
        }
        if ($cliente == 'p'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 1)->where('id', '!=', '22')->where('id', '!=', '23')
                            ->where('id', '!=', '24')->where('id', '!=', '25')->where('id', '!=', '26')
                            ->where('id', '!=', '27')->where('id', '!=', '28')->where('id', '!=', '29')
                            ->where('id', '!=', '30')->where('id', '!=', '31')
                            ->where('id', '!=', '32')->where('id', '!=', '33')->where('id', '!=', '34')
                            ->where('id', '!=', '35')->where('id', '!=', '36')->where('id', '!=', '37')
                            ->where('id', '!=', '38')->where('id', '!=', '39')
                            ->where('id', '!=', '40')->where('id', '!=', '41')->where('id', '!=', '42')
                            ->where('id', '!=', '43')->where('id', '!=', '44')->where('id', '!=', '45')
                            ->orWhere('categoria_id', '=', 6)->orWhere('categoria_id', '=', 7)->get(); //el estado "0" son los tipo de pago activos
            return json_encode($tipo);
        }
    }

    public function SerieDePagoAspirante(Request $request)
    {
        $serie = $request->stateID;
        if ($serie == 'a'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '!=', 1)->where('categoria_id', '!=', 3)->orWhere('id', '=', '11')->orWhere('id', '=', '12')->get();
            return json_encode($tipo);
        }
        if ($serie == 'b'){
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 1)->where('id', '!=', '22')->where('id', '!=', '23')
                            ->where('id', '!=', '24')->where('id', '!=', '25')->where('id', '!=', '26')
                            ->where('id', '!=', '27')->where('id', '!=', '28')->where('id', '!=', '29')
                            ->where('id', '!=', '30')->where('id', '!=', '31')
                            ->where('id', '!=', '32')->where('id', '!=', '33')->where('id', '!=', '34')
                            ->where('id', '!=', '35')->where('id', '!=', '36')->where('id', '!=', '37')
                            ->where('id', '!=', '38')->where('id', '!=', '39')
                            ->where('id', '!=', '40')->where('id', '!=', '41')->where('id', '!=', '42')
                            ->where('id', '!=', '43')->where('id', '!=', '44')->where('id', '!=', '45')
                            ->orWhere('categoria_id', '=', 6)->orWhere('categoria_id', '=', 7)->get(); //el estado "0" son los tipo de pago activos
            return json_encode($tipo);
        }
    }

    public function consultaTimbres(Request $request)
    {
        $tipoPago = TipoDePago::where('codigo', $request->indicador)->get()->first();
        // consulta para saber a que bodega pertenece el cajero o usuario loggeado
        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $request->user";
            $result = DB::select($query);

        if (empty($result)){
            $error = 'Usuario no cuenta con bodega asignada';
            return response()->json($error, 500);
        }else { $bodega = $result[0]->bodega; }

        // consulta para saber que codigo de timbre corresponde el tipo de pago
        $consulta = TiposDeProductos::select('timbre_id')->where('tipo_de_pago_id', $tipoPago->id)->get()->first();

        // consulta para saber la cantidad total de timbres por codigo de timbre y bodega
        $query = "SELECT SUM(cantidad) as cantidadTotal FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega";
        $result = DB::select($query);
        $cantidadTotal = $result[0]->cantidadTotal;

        if (intval($cantidadTotal) >= intval($request->cantidad)){ // si la existencia en bodega es mayor inicia la operacion para desplegar dato de timbre

            $consulta1 = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega AND cantidad != 0 ORDER BY id ASC";
            $result = DB::select($consulta1);
            $mensaje = "timbres Entregados: ";

            foreach($result as $res)
            {

                $cant1 = $res->cantidad;
                $total = $res->cantidad - $request->cantidad;
                if ($total >= 0) {
                    $numeroInicio = $res->numeracion_inicial;
                    $numeroFinal = $res->numeracion_inicial + $request->cantidad - 1;

                    // if (intval($numeroInicio) == intval($numeroFinal)){
                    //     $mensaje = "timbre Entregado: " . $numeroFinal;
                    //     return $mensaje;
                    // }
                    $mensaje .= $numeroInicio . "-" . $numeroFinal;
                    return json_encode($mensaje);
                } else {
                    $numeroInicio = $res->numeracion_inicial;
                    $numeroFinal = $res->numeracion_final;

                    $mensaje .= $numeroInicio . "-" .$numeroFinal . ", ";

                    $request->cantidad = $total * -1;
                }
            }
        } else {
            $error = 'No hay existencia en su bodega para realizar esta venta';
            return response()->json(['mensaje' => $error, 'timbre' => $request->indicador], 500);
        }
    }

    public function existenciaBodega(Request $request)
    {
        // consulta para saber a que bodega pertenece el cajero o usuario loggeado
        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $request->user";
            $result = DB::select($query);
        $bodega = $result[0]->bodega;

        // consulta para saber que codigo de timbre corresponde el tipo de pago
        $consulta = TiposDeProductos::select('timbre_id')->where('tipo_de_pago_id', $request->codigo)->get()->first();

        // consulta para saber la cantidad total de timbres por codigo de timbre y bodega
        $query = "SELECT SUM(cantidad) as cantidadTotal FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega";
        $result = DB::select($query);
        $cantidadTotal = $result[0]->cantidadTotal;

        return $cantidadTotal;
    }

    public function codigosTimbrePago(Request $request) {
        // $montoTemp = $this->monto_timbre * $cantidad;
        $montoTemp = $request->subtotal;
        // dd($request);

        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $request->user";
            $result = DB::select($query);
        $bodega = $result[0]->bodega;
        // dd($montoTemp);
        $valores = [
          0=> ['timbre_id'=>'8','precio'=>'500'],
          1=> ['timbre_id'=>'7','precio'=>'200'],
          2=> ['timbre_id'=>'6','precio'=>'100'],
          3=> ['timbre_id'=>'5','precio'=>'50'],
          4=> ['timbre_id'=>'4','precio'=>'20'],
          5=> ['timbre_id'=>'3','precio'=>'10'],
          6=> ['timbre_id'=>'2','precio'=>'5'],
          7=> ['timbre_id'=>'1','precio'=>'1'],
        ];

        $retorno = array();
        foreach($valores as $valor) {

          if($montoTemp >= $valor['precio']) {
                $existenciaTimbre=IngresoProducto::where('timbre_id',$valor['timbre_id'])->where('bodega_id',$bodega)->where('cantidad','!=',0)->sum('cantidad');
                $id = $valor['timbre_id'];
                $consulta1 = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = $id AND bodega_id = $bodega AND cantidad != 0 ORDER BY id ASC";
                $result = DB::select($consulta1);

            if($existenciaTimbre > 0){
              $divisionEntera = intdiv($montoTemp, $valor['precio']);
              if($divisionEntera <= $existenciaTimbre){
                  $montoTemp -= $valor['precio'] * $divisionEntera;
                  $detalle = new \stdClass();
                  $detalle->codigo = 'TC' . str_pad($valor['precio'], 2, '0', STR_PAD_LEFT);
                  $detalle->descripcion = 'Timbre por cuota de ' . $valor['precio'] . ' quetzales';
                  $detalle->precioUnitario = $valor['precio'];
                  $detalle->timbre_id = $valor['timbre_id'];
                  $detalle->cantidad = $divisionEntera;
                  $detalle->numeroInicial = $result[0]->numeracion_inicial;
                  $detalle->numeroFinal = $result[0]->numeracion_inicial + $divisionEntera -1;
                  $retorno[] = $detalle;
              }else{
                  $montoTemp -= $valor['precio'] * $existenciaTimbre;
                  $detalle = new \stdClass();
                  $detalle->codigo = 'TC' . str_pad($valor['precio'], 2, '0', STR_PAD_LEFT);
                  $detalle->descripcion = 'Timbre por cuota de ' . $valor['precio'] . ' quetzales';
                  $detalle->precioUnitario = $valor['precio'];
                  $detalle->timbre_id = $valor['timbre_id'];
                  $detalle->cantidad = $existenciaTimbre;
                  $detalle->numeroInicial = $result[0]->numeracion_inicial;
                  $detalle->numeroFinal = $result[0]->numeracion_inicial + $divisionEntera -1;
                  $retorno[] = $detalle;
              }
            }
          }
        }


        if(!empty($retorno)){
            foreach($retorno as $timbre){
                $existencias=\App\IngresoProducto::where('timbre_id',$timbre->timbre_id)->where('bodega_id',$bodega)->where('cantidad','!=',0)->get();
                $cantidadDatos = 0;
                foreach($existencias as $existencia){
                    if($timbre->cantidad <= $existencia->cantidad){
                        $detalle1 = new \stdClass();
                        $detalle1->numeracion_inicial = $existencia->numeracion_inicial;
                        $detalle1->numeracion_final = $existencia->numeracion_inicial + $timbre->cantidad -1 ;
                        $detalle1->cantidad = $timbre->cantidad;
                        $detalle1->codigo = $timbre->codigo;
                        $detalle1->timbre_id = $timbre->timbre_id;
                        $detalle1->cantidadDatos = $cantidadDatos+1;
                        $detalle1->lote = $existencia->id;
                        $retorno1[] = $detalle1;
                     break;
                    }else{
                        $detalle1 = new \stdClass();
                        $detalle1->numeracion_inicial = $existencia->numeracion_inicial;
                        $detalle1->numeracion_final = $existencia->numeracion_final ;
                        $detalle1->cantidad = $existencia->cantidad;
                        $detalle1->codigo = $timbre->codigo;
                        $detalle1->timbre_id = $timbre->timbre_id;
                        $detalle1->lote = $existencia->id;
                        $detalle1->cantidadDatos = $cantidadDatos+1;
                        $retorno1[] = $detalle1;
                        $timbre->cantidad -= $existencia->cantidad;
                    }
                }
            }
        }

        if(empty($retorno1)){
            $detalle1 = new \stdClass();
            $detalle1->haydatos = "no";
            $retorno1[] = $detalle1;
        }

        return json_encode($retorno1);
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
        $emisionDeRecibo    = $request->input("config.emisionDeRecibo");

        if($emisionDeRecibo == 'colegiado'){

            $serieRecibo        = $request->input("config.tipoSerieRecibo");
            $tipoDeCliente      = $request->input("config.tipoDeCliente");
            $colegiado          = $request->input("config.numeroColegiado");
            $nombreCliente      = $request->input("config.n_cliente");
            $estado             = $request->input("config.estado");
            $complemento        = $request->input("config.complemento");
            $ultPagoTimbre      = $request->input("config.f_ult_timbre");
            $fechaPagoTimbre    = $request->input("config.fechaTimbre");
            $ultPagoColegio     = $request->input("config.f_ult_pago");
            $fechaPagoColegio   = $request->input("config.fechaColegio");
            $montoTimbre        = $request->input("config.monto_timbre");
            $montoTimbre        = substr($montoTimbre,2);
            $totalAPagar        = $request->input("config.total");
            $totalAPagar        = substr($totalAPagar,2);
            $pagoEnEfectivo     = $request->input("config.pagoEfectivo");
            $montoefectivo      = $request->input("config.montoefectivo");
            $pagoCheque         = $request->input("config.pagoCheque");
            $numeroCheque       = $request->input("config.cheque");
            $montoCheque        = $request->input("config.montoCheque");
            $pagoTarjeta        = $request->input("config.pagoTarjeta");
            $numeroTarjeta      = $request->input("config.tarjeta");
            $montoTarjeta       = $request->input("config.montoTarjeta");
            $pos_id             = $request->input("pos");
            $pagoDeposito       = $request->input("config.pagoDeposito");
            $mesesASumar        = $request->input("nuevaFechaColegio");
            $totalPrecioTimbre  = $request->totalPrecioTimbre;
            $banco_id           = $request->banco;
            $banco_id_deposito  = $request->bancoDeposito;

            $tipoDeCliente = 1;
            if ($serieRecibo == 'a') {
                $serieRecibo = 1;
            } elseif ($serieRecibo == 'b') {
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
            $reciboMaestro->monto_deposito = $request->input("config.montoDeposito");
            $reciboMaestro->usuario = Auth::user()->id;
            $reciboMaestro->monto_total = $totalAPagar;
            $reciboMaestro->save();
            $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
            if (empty($id_estado_cuenta)) {
                $cuentaM = \App\EstadoDeCuentaMaestro::create([
                    'colegiado_id'         =>$colegiado,
                    'estado_id'            => '1',
                    'fecha_creacion'       => date('Y-m-d h:i:s'),
                    'usuario_id'           => '1',
                ]);
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
            }
            $array = $request->input("datos");

            $numMes = new Carbon($fechaPagoColegio);
            // $sumademes = 0;

            for ($i = 1; $i < sizeof($array); $i++) {
                if ($array[$i][1] != 'timbre-mensual'){
                    if ($array[$i][1] == 'COL092'){
                        $cant = intval($array[$i][2]);
                        for ($d = 0; $d < $cant; $d++) {
                            // $sumademes = $sumademes+1;
                            $sumadefecha = $numMes->startofMonth()->addMonths(1)->toDateString();
                            $mes = date("n", strtotime($sumadefecha));
                            $anio = date("Y", strtotime($sumadefecha));
                            $reciboDetalle = Recibo_Detalle::create([
                                'numero_recibo'     => $reciboMaestro->numero_recibo,
                                'codigo_compra'     => $array[$i][1],
                                'cantidad'          => 1,
                                'precio_unitario'   => substr($array[$i][3],2),
                                'total'             => substr($array[$i][3],2),
                                'id_mes'            => $mes,
                                'año'               => $anio,
                            ]);
                            $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                            $reciboDetalle->id, $reciboDetalle->total, 0,Auth::user()->id, $mes, $anio);

                        }
                    } else {
                        $tipoPago= \App\TipoDePago::where('id',$array[$i][0])->get()->first();
                        if($tipoPago->categoria_id != 1){
                            $reciboDetalle = Recibo_Detalle::create([
                                'numero_recibo'     => $reciboMaestro->numero_recibo,
                                'codigo_compra'     => $array[$i][1],
                                'cantidad'          => $array[$i][2],
                                'precio_unitario'   => substr($array[$i][3],2),
                                'total'             => substr($array[$i][5],2),
                            ]);
                            //abono estado cuenta
                            $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                            $reciboDetalle->id, 0, $reciboDetalle->total,Auth::user()->id,'','');
                            //cargo estado cuenta
                            $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                            $reciboDetalle->id, $reciboDetalle->total, 0,Auth::user()->id,'','');

                        }
                    }
                }
            }

            if ($pagoCheque == 'si') {
                $banco = Banco::where('id', '=', $banco_id)->get()->first();
                $bdCheque = new ReciboCheque;
                $bdCheque->numero_recibo = $reciboMaestro->numero_recibo;
                $bdCheque->numero_cheque = $numeroCheque;
                $bdCheque->monto = $montoCheque;
                $bdCheque->nombre_banco = $banco->nombre_banco;
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

            if ($pagoDeposito == 'si'){
                $bdDeposito = new ReciboDeposito;
                $bdDeposito->numero_recibo = $reciboMaestro->numero_recibo;
                $bdDeposito->monto = $request->input("config.montoDeposito");
                $bdDeposito->numero_boleta = $request->input("config.deposito");
                $bdDeposito->fecha = date('Y-m-d h:i:s', strtotime($request->input("config.fechaDeposito")));
                $bdDeposito->banco_id = $banco_id_deposito;
                $bdDeposito->usuario_id = Auth::user()->id;
                $bdDeposito->save();
            }

            if($mesesASumar != null){
                $valMesesASumar = $mesesASumar / 115.75;
                $fechaPagoColegio = new Carbon($fechaPagoColegio);
                $nuevaFecha = $fechaPagoColegio->startofMonth()->addMonths($valMesesASumar+1)->subSeconds(1)->toDateTimeString();
                $nuevaFecha = date('Y-m-d h:i:s', strtotime($nuevaFecha));
                $query = "UPDATE cc00 SET f_ult_pago = :nuevaFecha WHERE c_cliente = :colegiado";
                $parametros = array(
                    ':nuevaFecha' => $nuevaFecha, ':colegiado' => $colegiado
                );
                $result = DB::connection('sqlsrv')->update($query, $parametros);

            }

            if($totalPrecioTimbre != null){
                $cantMensualidades = $totalPrecioTimbre / $montoTimbre;
                $fechaPagoTimbre = new Carbon($fechaPagoTimbre);
                $nuevaFecha = $fechaPagoTimbre->startofMonth()->addMonths($cantMensualidades+1)->subSeconds(1)->toDateTimeString();
                $nuevaFecha = date('Y-m-d h:i:s', strtotime($nuevaFecha));
                $query = "UPDATE cc00 SET f_ult_timbre = :nuevaFecha WHERE c_cliente = :colegiado";
                $parametros = array(
                    ':nuevaFecha' => $nuevaFecha, ':colegiado' => $colegiado
                );
                $result = DB::connection('sqlsrv')->update($query, $parametros);
            }

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request, $reciboMaestro->numero_recibo);
            // try {
                $datos_colegiado = SQLSRV_Colegiado::select('e_mail', 'n_cliente')->where('c_cliente', $colegiado)->get();
                $this->envioReciboElectronico($colegiado,$tipoDeCliente,$reciboMaestro->numero_recibo,$datos_colegiado[0]->e_mail);
                return response()->json(['success' => 'Todo Correcto']);
            // } catch (\Throwable $th) {
            //     return response()->json(['success' => 'Exito-No se envio correo']);
            // }


        } elseif ($emisionDeRecibo == 'particular'){
                // almacen de datos de PARTICULAR

            $serieReciboP        = $request->input("config.tipoSerieReciboP");
            $tipoDeCliente       = $request->input("config.tipoDeCliente");
            $dpi                 = $request->input("config.dpi");
            $nombreClienteP      = $request->input("config.nombreP");
            $totalAPagarP        = $request->input("config.totalP");
            $totalAPagarP        = substr($totalAPagarP,2);
            $pagoEnEfectivoP     = $request->input("config.pagoEfectivoP");
            $montoefectivoP      = $request->input("config.montoefectivoP");
            $pagoChequeP         = $request->input("config.pagoChequeP");
            $numeroChequeP       = $request->input("config.chequeP");
            $montoChequeP        = $request->input("config.montoChequeP");
            $pagoTarjetaP        = $request->input("config.pagoTarjetaP");
            $numeroTarjetaP      = $request->input("config.tarjetaP");
            $montoTarjetaP       = $request->input("config.montoTarjetaP");
            $pos_idP             = $request->input("pos");
            $pagoDepositoP       = $request->input("config.pagoDepositoP");
            $banco_id            = $request->banco;
            $banco_id_depositoP  = $request->bancoDepositoP;
            $esAspirante         = $request->esAspirante;

            $tipoDeCliente = 2;
            if ($serieReciboP == 'a') {
                $serieReciboP = 1;
            } elseif ($serieReciboP == 'b') {
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
            $reciboMaestroP->monto_deposito = $montoChequeP;
            $reciboMaestroP->usuario = Auth::user()->id;
            $reciboMaestroP->monto_total = $totalAPagarP;
            $reciboMaestroP->e_mail = $request->input("config.emailp");
            $reciboMaestroP->save();

            $array = $request->input("datos");

            for ($i = 1; $i < sizeof($array); $i++) {
                if ($array[$i][1] != 'timbre-mensual'){
                    $reciboDetalleP = Recibo_Detalle::create([
                        'numero_recibo'     => $reciboMaestroP->numero_recibo,
                        'codigo_compra'     => $array[$i][1],
                        'cantidad'          => $array[$i][2],
                        'precio_unitario'   => substr($array[$i][3],2),
                        'total'             => substr($array[$i][5],2),
                    ]);
                }
            }

            if ($esAspirante == 'si') {
                $query = Aspirante::where("dpi",$dpi)->get();

                $reciboAspirante = new ReciboAspirante;
                $reciboAspirante->numero_recibo = $reciboMaestroP->numero_recibo;
                $reciboAspirante->id_aspirante =  $query[0]->id;
                $reciboAspirante->save();
            }

            if ($pagoChequeP == 'si') {
                $banco = Banco::where('id', '=', $banco_id)->get()->first();

                $bdChequeP = new ReciboCheque;
                $bdChequeP->numero_recibo = $reciboMaestroP->numero_recibo;
                $bdChequeP->numero_cheque = $numeroChequeP;
                $bdChequeP->monto = $montoChequeP;
                $bdChequeP->nombre_banco = $banco->nombre_banco;
                $bdChequeP->usuario_id = Auth::user()->id;
                $bdChequeP->fecha_de_cheque = now();
                $bdChequeP->save();
            }

            if ($pagoTarjetaP == 'si') {
                $bdTarjetaP = new ReciboTarjeta;
                $bdTarjetaP->numero_recibo = $reciboMaestroP->numero_recibo;
                $bdTarjetaP->numero_voucher = $numeroTarjetaP;
                $bdTarjetaP->monto = $montoTarjetaP;
                $bdTarjetaP->pos_cobro_id = $pos_idP;
                $bdTarjetaP->usuario_id = Auth::user()->id;
                $bdTarjetaP->save();
            }

            if ($pagoDepositoP == 'si'){
                $bdDeposito = new ReciboDeposito;
                $bdDeposito->numero_recibo = $reciboMaestroP->numero_recibo;
                $bdDeposito->monto = $request->input("config.montoDepositoP");
                $bdDeposito->numero_boleta = $request->input("config.depositoP");
                $bdDeposito->fecha = date('Y-m-d h:i:s', strtotime($request->input("config.fechaDepositoP")));
                $bdDeposito->banco_id = $banco_id_depositoP;
                $bdDeposito->usuario_id = Auth::user()->id;
                $bdDeposito->save();
            }

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request, $reciboMaestroP->numero_recibo);


                try {
                    $this->envioReciboElectronico($dpi,$tipoDeCliente,$reciboMaestroP->numero_recibo,$reciboMaestroP->e_mail);
                    return response()->json(['success' => 'Exito']);
                } catch (\Throwable $th) {
                    return response()->json(['success' => 'Exito-No se envio correo']);
                }



        } elseif ($emisionDeRecibo == 'empresa'){
                // almacen de datos de EMPRESA

            $serieReciboE        = $request->input("config.tipoSerieReciboE");
            $tipoDeCliente       = $request->input("config.tipoDeCliente");
            $nit                 = $request->input("config.nit");
            $empresa             = $request->input("config.empresa");
            $totalAPagarE        = $request->input("config.totalE");
            $totalAPagarE        = substr($totalAPagarE,2);
            $pagoEnEfectivoE     = $request->input("config.pagoEfectivoE");
            $montoefectivoE      = $request->input("config.montoefectivoE");
            $pagoChequeE         = $request->input("config.pagoChequeE");
            $numeroChequeE       = $request->input("config.chequeE");
            $montoChequeE        = $request->input("config.montoChequeE");
            $pagoTarjetaE        = $request->input("config.pagoTarjetaE");
            $numeroTarjetaE      = $request->input("config.tarjetaE");
            $montoTarjetaE       = $request->input("config.montoTarjetaE");
            $pos_idE             = $request->input("pos");
            $pagoDepositoE       = $request->input("config.pagoDepositoE");
            $banco_id            = $request->banco;
            $banco_id_depositoE  = $request->bancoDepositoE;

            $tipoDeCliente = 3;
            if ($serieReciboE == 'a') {
                $serieReciboE = 1;
            } elseif ($serieReciboE == 'b') {
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
            $reciboMaestroE->monto_deposito = $request->input("config.montoDepositoE");
            $reciboMaestroE->usuario = Auth::user()->id;
            $reciboMaestroE->monto_total = $totalAPagarE;
            $reciboMaestroE->save();

            $array = $request->input("datos");

            for ($i = 1; $i < sizeof($array); $i++) {
                $tipoPago= \App\TipoDePago::where('id',$array[$i][0])->get()->first();
                if($tipoPago->categoria_id != 1){
                    $reciboDetalleE = Recibo_Detalle::create([
                        'numero_recibo'     => $reciboMaestroE->numero_recibo,
                        'codigo_compra'     => $array[$i][1],
                        'cantidad'          => $array[$i][2],
                        'precio_unitario'   => substr($array[$i][3],2),
                        'total'             => substr($array[$i][5],2),
                    ]);
                }
            }

            if ($pagoChequeE == 'si') {
                $banco = Banco::where('id', '=', $banco_id)->get()->first();

                $bdChequeE = new ReciboCheque;
                $bdChequeE->numero_recibo = $reciboMaestroE->numero_recibo;
                $bdChequeE->numero_cheque = $numeroChequeE;
                $bdChequeE->monto = $montoChequeE;
                $bdChequeE->nombre_banco = $banco->nombre_banco;
                $bdChequeE->usuario_id = Auth::user()->id;
                $bdChequeE->fecha_de_cheque = now();
                $bdChequeE->save();
            }

            if ($pagoTarjetaE == 'si') {
                $bdTarjetaE = new ReciboTarjeta;
                $bdTarjetaE->numero_recibo = $reciboMaestroE->numero_recibo;
                $bdTarjetaE->numero_voucher = $numeroTarjetaE;
                $bdTarjetaE->monto = $montoTarjetaE;
                $bdTarjetaE->pos_cobro_id = $pos_idE;
                $bdTarjetaE->usuario_id = Auth::user()->id;
                $bdTarjetaE->save();
            }

            if ($pagoDepositoE == 'si'){
                $bdDeposito = new ReciboDeposito;
                $bdDeposito->numero_recibo = $reciboMaestroE->numero_recibo;
                $bdDeposito->monto = $request->input("config.montoDepositoE");
                $bdDeposito->numero_boleta = $request->input("config.depositoE");
                $bdDeposito->fecha = date('Y-m-d h:i:s', strtotime($request->input("config.fechaDepositoE")));
                $bdDeposito->banco_id = $banco_id_depositoE;
                $bdDeposito->usuario_id = Auth::user()->id;
                $bdDeposito->save();
            }

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request, $reciboMaestroE->numero_recibo);



               try {
                $empresa1 = SQLSRV_Empresa::select('e_mail', 'EMPRESA','NIT')->where('CODIGO', $nit)->get();
                $this-> envioReciboElectronico($nit,$tipoDeCliente,$reciboMaestroE->numero_recibo,$empresa1[0]->e_mail);

                return response()->json(['success' => 'Exito-Correo Enviado']);
                } catch (\Throwable $th) {
                    return response()->json(['success' => 'Exito- No se pudo enviar el correo electronico']);
                }


        }
    }

    public function codigosTimbrePago2($montoTemp, $user )
    {
        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
            $result = DB::select($query);
        $bodega = $result[0]->bodega;

        $valores = [
            0=> ['timbre_id'=>'8','precio'=>'500','tipo_de_pago_id'=>'37'],
            1=> ['timbre_id'=>'7','precio'=>'200','tipo_de_pago_id'=>'35'],
            2=> ['timbre_id'=>'6','precio'=>'100','tipo_de_pago_id'=>'33'],
            3=> ['timbre_id'=>'5','precio'=>'50','tipo_de_pago_id'=>'36'],
            4=> ['timbre_id'=>'4','precio'=>'20','tipo_de_pago_id'=>'34'],
            5=> ['timbre_id'=>'3','precio'=>'10','tipo_de_pago_id'=>'32'],
            6=> ['timbre_id'=>'2','precio'=>'5','tipo_de_pago_id'=>'31'],
            7=> ['timbre_id'=>'1','precio'=>'1','tipo_de_pago_id'=>'30'],
        ];

        $retorno = array();
        foreach($valores as $valor) {

          if($montoTemp >= $valor['precio']) {
                $existenciaTimbre=IngresoProducto::where('timbre_id',$valor['timbre_id'])->where('bodega_id',$bodega)->where('cantidad','!=',0)->sum('cantidad');
                $id = $valor['timbre_id'];
                $consulta1 = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = $id AND bodega_id = $bodega AND cantidad != 0 ORDER BY id ASC";
                $result = DB::select($consulta1);

            if($existenciaTimbre > 0){
              $divisionEntera = intdiv($montoTemp, $valor['precio']);
              if($divisionEntera <= $existenciaTimbre){
                  $montoTemp -= $valor['precio'] * $divisionEntera;
                  $detalle = new \stdClass();
                  $detalle->codigo = 'TC' . str_pad($valor['precio'], 2, '0', STR_PAD_LEFT);
                  $detalle->descripcion = 'Timbre por cuota de ' . $valor['precio'] . ' quetzales';
                  $detalle->precioUnitario = $valor['precio'];
                  $detalle->tipo_de_pago_id = $valor['tipo_de_pago_id'];
                  $detalle->timbre_id = $valor['timbre_id'];
                  $detalle->precioUnitario = $valor['precio'];
                  $detalle->cantidad = $divisionEntera;
                  $detalle->numeroInicial = $result[0]->numeracion_inicial;
                  $detalle->numeroFinal = $result[0]->numeracion_inicial + $divisionEntera -1;
                  $retorno[] = $detalle;
              }else{
                  $montoTemp -= $valor['precio'] * $existenciaTimbre;
                  $detalle = new \stdClass();
                  $detalle->codigo = 'TC' . str_pad($valor['precio'], 2, '0', STR_PAD_LEFT);
                  $detalle->descripcion = 'Timbre por cuota de ' . $valor['precio'] . ' quetzales';
                  $detalle->precioUnitario = $valor['precio'];
                  $detalle->tipo_de_pago_id = $valor['tipo_de_pago_id'];
                  $detalle->timbre_id = $valor['timbre_id'];
                  $detalle->precioUnitario = $valor['precio'];
                  $detalle->cantidad = $existenciaTimbre;
                  $detalle->numeroInicial = $result[0]->numeracion_inicial;
                  $detalle->numeroFinal = $result[0]->numeracion_inicial + $divisionEntera -1;
                  $retorno[] = $detalle;
              }
            }
          }
        }


        if(!empty($retorno)){
            foreach($retorno as $timbre){
                $existencias=\App\IngresoProducto::where('timbre_id',$timbre->timbre_id)->where('bodega_id',$bodega)->where('cantidad','!=',0)->get();
                $cantidadDatos = 0;
                foreach($existencias as $existencia){
                    if($timbre->cantidad <= $existencia->cantidad){
                        $detalle1 = new \stdClass();
                        $detalle1->numeracion_inicial = $existencia->numeracion_inicial;
                        $detalle1->numeracion_final = $existencia->numeracion_inicial + $timbre->cantidad -1 ;
                        $detalle1->cantidad = $timbre->cantidad;
                        $detalle1->codigo = $timbre->codigo;
                        $detalle1->tipo_de_pago_id = $timbre->tipo_de_pago_id;
                        $detalle1->timbre_id = $timbre->timbre_id;
                        $detalle1->precioUnitario = $timbre->precioUnitario;
                        $detalle1->lote = $existencia->id;
                        $retorno1[] = $detalle1;
                     break;
                    }else{
                        $detalle1 = new \stdClass();
                        $detalle1->numeracion_inicial = $existencia->numeracion_inicial;
                        $detalle1->numeracion_final = $existencia->numeracion_final ;
                        $detalle1->cantidad = $existencia->cantidad;
                        $detalle1->codigo = $timbre->codigo;
                        $detalle1->tipo_de_pago_id = $timbre->tipo_de_pago_id;
                        $detalle1->timbre_id = $timbre->timbre_id;
                        $detalle1->lote = $existencia->id;
                        $detalle1->precioUnitario = $timbre->precioUnitario;
                        $retorno1[] = $detalle1;
                        $timbre->cantidad -= $existencia->cantidad;
                    }
                }
            }
        }

        if(empty($retorno1)){
            $detalle1 = new \stdClass();
            $detalle1->haydatos = "no";
            $retorno1[] = $detalle1;
        }

        return $retorno1;
    }

    public function registrarVenta($codigoC, $cantidad, $reciboDetalleId, $bodega)
    {
        $tipoPago = TipoDePago::where('codigo', $codigoC)->get()->first();
        $tipoServicio = TiposDeProductos::where('tipo_de_pago_id', $tipoPago->id)->get()->first();
        $existencias = IngresoProducto::where('timbre_id', $tipoServicio->timbre_id)->where('bodega_id', $bodega)->where('cantidad', '!=', 0)->get();

        if (!empty($existencias)) {
            foreach ($existencias as $key => $existencia) {
                if ($cantidad <= $existencia->cantidad) {
                    $registroTimbres = new VentaDeTimbres;
                    $registroTimbres->recibo_detalle_id = $reciboDetalleId;
                    $registroTimbres->numeracion_inicial = $existencia->numeracion_inicial;
                    $registroTimbres->numeracion_final = $existencia->numeracion_inicial + $cantidad - 1;
                    $registroTimbres->save();
                    if ($cantidad == $existencia->cantidad) {
                        $existencia->numeracion_inicial = 0;
                        $existencia->numeracion_final = 0;
                        $existencia->cantidad = 0;
                        $existencia->update();
                    } else {
                        $existencia->numeracion_inicial = $existencia->numeracion_inicial + $cantidad;
                        $existencia->cantidad -= $cantidad;
                        $existencia->update();
                    }
                    break;
                } else {
                    $registroTimbres = new VentaDeTimbres;
                    $registroTimbres->recibo_detalle_id = $reciboDetalleId;
                    $registroTimbres->numeracion_inicial = $existencia->numeracion_inicial;
                    $registroTimbres->numeracion_final = $existencia->numeracion_final;
                    $registroTimbres->save();
                    $cantidad -= $existencia->cantidad;
                    $existencia->numeracion_inicial = 0;
                    $existencia->numeracion_final = 0;
                    $existencia->cantidad = 0;
                    $existencia->update();
                }
            }
        } else {
            return "No hay existencias";
        }
    }

    public function AlmacenDatosTimbre($request, $reciboMaestroId)
    {
        $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
        $colegiado = $request->input("config.numeroColegiado");
        $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
        $user = $request->input("config.rol_user");

        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
            $result = DB::select($query);
        $bodega = $result[0]->bodega;

        $emisionDeRecibo    = $request->input("config.emisionDeRecibo");

        $array = $request->input("datos");

            for ($i = 1; $i < sizeof($array); $i++) {
                if ($array[$i][1] == 'timbre-mensual'){
                    $regresoTimbres = $this->codigosTimbrePago2(substr($array[$i][5],2), $user);

                    foreach ($regresoTimbres as $key => $timbre) {
                        $reciboDetalle = \App\Recibo_Detalle::create([
                        'numero_recibo'     => $reciboMaestroId,
                        'codigo_compra'     => $timbre->codigo,
                        'cantidad'          =>  $timbre->cantidad,
                        'precio_unitario'   =>  $timbre->precioUnitario,
                        'total'             => $timbre->precioUnitario  *  $timbre->cantidad,
                        ]);
                                //abono estado cuenta
                                $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                                $reciboDetalle->id, $reciboDetalle->total, 0,Auth::user()->id,'','');

                        $this->registrarVenta($timbre->codigo, $timbre->cantidad, $reciboDetalle->id, $bodega);
                    }
                } elseif (substr($array[$i][1],0,2) == 'TE' || substr($array[$i][1],0,3) == 'TIM'){
                    $timbre = $array[$i][0];
                    $cantidad = $array[$i][2];
                    $servicioTimbre = TiposDeProductos::where('tipo_de_pago_id', $timbre)->get()->first();
                    $existencias= IngresoProducto::where('timbre_id',$servicioTimbre->timbre_id)->where('bodega_id',$bodega)->where('cantidad','!=',0)->get();

                    foreach ($existencias as $key => $existencia) {
                        if ($cantidad <= $existencia->cantidad ) {
                            $reciboDetalle = \App\Recibo_Detalle::create([
                              'numero_recibo'     => $reciboMaestroId,
                              'codigo_compra'     => $array[$i][1],
                              'cantidad'          => $array[$i][2],
                              'precio_unitario'   => substr($array[$i][3],2),
                              'total'             => substr($array[$i][5],2),
                            ]);

                            if (substr($array[$i][1],0,3) == 'TIM'){
                                //cargo estado cuenta
                                $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                                $reciboDetalle->id, 0, $reciboDetalle->total,Auth::user()->id,'','');
                                //abono estado cuenta
                                $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                                $reciboDetalle->id, $reciboDetalle->total, 0,Auth::user()->id,'','');
                            }

                                    $this->registrarVenta($array[$i][1], $cantidad, $reciboDetalle->id, $bodega);

                            break;
                          }else{
                              $reciboDetalle = \App\Recibo_Detalle::create([
                                'numero_recibo'     => $reciboMaestroId,
                                'codigo_compra'     => $array[$i][1],
                                'cantidad'          => $existencia->cantidad,
                                'precio_unitario'   => substr($array[$i][3],2),
                                'total'             => $existencia->cantidad * substr($array[$i][3],2),
                              ]);

                            if (substr($array[$i][1],0,3) == 'TIM'){
                                //cargo estado cuenta
                                $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                                $reciboDetalle->id, 0, $reciboDetalle->total,Auth::user()->id,'','');
                                //abono estado cuenta
                                $this->guardarEstadoCuenta($id_estado_cuenta->id, $reciboDetalle->cantidad, $reciboDetalle->codigo_compra,
                                $reciboDetalle->id, $reciboDetalle->total, 0,Auth::user()->id,'','');
                            }


                                    $this->registrarVenta($array[$i][1], $existencia->cantidad, $reciboDetalle->id, $bodega);

                              $cantidad -= $existencia->cantidad;
                          }
                    }
                }
            }
    }

    public function getDatosColegiado($colegiado)
    {
        $query = "SELECT n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                  WHERE c_cliente = $colegiado AND DATEDIFF(month, f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, f_ult_timbre, GETDATE()) <= 3";
        $result = DB::connection('sqlsrv')->select($query);

        if (!empty($result)) {
            $result[0]->estado = 'Activo';

            return $result;
        } else {
            $query = "SELECT n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                      WHERE c_cliente = $colegiado AND DATEDIFF(month, f_ult_pago, GETDATE()) > 3 and DATEDIFF(month, f_ult_timbre, GETDATE()) > 3";
            $resultado = DB::connection('sqlsrv')->select($query);

            if (empty($resultado)) {
                $query = "SELECT n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                          WHERE c_cliente = $colegiado and DATEDIFF(month, f_ult_timbre, GETDATE()) > 3";
                $resultado1 = DB::connection('sqlsrv')->select($query);

                if (empty($resultado1)) {
                    $query = "SELECT n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                              WHERE c_cliente = $colegiado and DATEDIFF(month, f_ult_pago, GETDATE()) > 3";
                    $resultado2 = DB::connection('sqlsrv')->select($query);
                    $resultado2[0]->estado = 'Inactivo';

                    return $resultado2;
                }

                $resultado1[0]->estado = 'Inactivo';
                return $resultado1;
            }

            $resultado[0]->estado = 'Inactivo';
            return $resultado;
        }
    }

    public function getDatosEmpresa($nit)
    {
        $consulta = SQLSRV_Empresa::select('empresa')
            ->where('nit', $nit)->get()->first();

        return $consulta;
    }

    public function getTipoDePagoA($tipo)
    {
        $consulta = TipoDePago::select('codigo', 'tipo_de_pago', 'precio_colegiado', 'precio_particular', 'categoria_id')
            ->where('id', $tipo)->where('estado', '=', 0)->get()->first();

        return $consulta;
    }

    public function getTipoDePagoB($tipo)
    {
        $consulta = TipoDePago::select('codigo', 'tipo_de_pago', 'precio_colegiado', 'precio_particular', 'categoria_id')
            ->where('id', $tipo)->where('estado', '=', 0)->get()->first();

        return $consulta;
    }

    public function existenciaDpi($valid){
        // dd($request);
        $dato = $valid;
        $query = Aspirante::where("dpi",$dato)->get();
             $contador = count($query);
        if ($contador == 0 )
        {
            $query->pertenece = 'no';
            return json_encode($query);
        }
        else
        {
            $query->pertenece = 'si';
            return json_encode($query);
        }
    }

    public function getDatosReactivacion()
    {
        return view('admin.creacionRecibo.interes');
    }
    //   ----------------------------------------> datos de reactivacion <----------------------------------------
    public function getMontoReactivacion()
    {
        $fecha_timbre = Input::get('fecha_timbre', date("Y-m-t"));
        $fecha_colegio = Input::get('fecha_colegio', date("y-m-t"));
        $colegiado = Input::get('colegiado');
        $fecha_hasta_donde_paga = Input::get('fecha_hasta_donde_paga', date("Y-m-t"));
        $monto_timbre = Input::get('monto_timbre', 0);
        $monto_timbre = substr($monto_timbre, 2);

        if (!$fecha_timbre || !$fecha_hasta_donde_paga || !$monto_timbre) {
            return json_encode(array("capital" => 0, "mora" => 0, "interes" => 0, "total" => 0));
        }
        $reactivacion = [];
        $reactivacionColegio = $this->getMontoReactivacionColegio($fecha_colegio, $fecha_hasta_donde_paga, $colegiado);
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
        $mes_origen = substr($fecha_timbre, -7, 2);
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

        $capital = round($monto_timbre * ($anio_fin * 12 + $mes_fin - ($anio_origen * 12 + $mes_origen)));
        $mora = round($monto_timbre * 0.18 / 12 * $diferencia * ($diferencia - 1) / 2);
        $intereses = round($monto_timbre * 0.128 / 12 * $diferencia * ($diferencia - 1) / 2);
        if ($exonerar_intereses_timbre == 1) {
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
        $fechaFinMes = strtotime(date('Y-m-t', strtotime(date('Y') . '-' . (date('m') - 3) . '-01')));
        $fechaTope = $fechaHastaT;
        if ($fechaHastaT > $fechaFinMes) {
            $fechaTope = $fechaFinMes;
        }

        $fechaultimopagocolegio = $fecha_colegio;

        $fechaDesdeT = strtotime($fechaultimopagocolegio);
        $cuotas = date('Y', $fechaTope) * 12 + date('m', $fechaTope) - (date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT));
        $cuotasD = date('Y', $fechaHastaT) * 12 + date('m', $fechaHastaT) - (date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT));
        $d = $cuotasD - $cuotas;
        $porcentajeInteres = 8.5;
        $montoBase = 40.75;
        $montoInteresAtrasado = 0;
        if ($cuotas > 0) {
            //$montoInteresAtrasado = $this->calculoPotenciaColegio($cuotas, $porcentajeInteres, $montoBase);
        }

        $mesesTemp = date('Y', $fechaHastaT) * 12 + date('m', $fechaHastaT);
        $mesesDesdeTemp = date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT);
        $cuotasTemp = $mesesDesdeTemp - $mesesTemp;
        $mesesAnterior = 1983 * 12 + 2;
        $montoAnterior = 6;
        $totalMontoColegio = 0;

        $montosPago = [['meses' => 1983 * 12 + 2, 'monto' => 6, 'codigo' => 'COL01', 'auxilio' => 0], ['meses' => 1989 * 12 + 12, 'monto' => 12, 'codigo' => 'COL02', 'auxilio' => 6], ['meses' => 1990 * 12 + 12, 'monto' => 23.25, 'codigo' => 'COL03', 'auxilio' => 12.75], ['meses' => 1991 * 12 + 9, 'monto' => 30, 'codigo' => 'COL04', 'auxilio' => 12.75], ['meses' => 2001 * 12 + 9, 'monto' => 39, 'codigo' => 'COL05', 'auxilio' => 12.75], ['meses' => 2001 * 12 + 12, 'monto' => 60, 'codigo' => 'COL06', 'auxilio' => 22.75], ['meses' => 2010 * 12 + 10, 'monto' => 65, 'codigo' => 'COL07', 'auxilio' => 22.75], ['meses' => 2011 * 12 + 8, 'monto' => 78.5, 'codigo' => 'COL08', 'auxilio' => 22.75], ['meses' => 2013 * 12 + 1, 'monto' => 98.5, 'codigo' => 'COL091', 'auxilio' => 22.75], ['meses' => date('Y') * 12 + date('m'), 'monto' => 115.75, 'codigo' => 'COL092', 'auxilio' => 40.75]];
        $detalleMontos = [];
        $montoInteresAtrasado = 0;
        foreach ($montosPago as $montoPago) {

            if ($mesesDesdeTemp <= $montoPago['meses']) {
                $diferencia = $montoPago['meses'] - $mesesDesdeTemp >= 0 ? $montoPago['meses'] - $mesesDesdeTemp : 0;
                $dif2 = $mesesTemp - $mesesDesdeTemp;
                if ($montoPago['monto'] == 115.75) {
                    $diferencia += $d;
                }


                $totalMontoColegio += $diferencia * $montoPago['monto'];
                $cuotasTemp -= $diferencia;
                $mesesDesdeTemp = $montoPago['meses'];
                $detalleMontos[] = ['codigo' => $montoPago['codigo'], 'cuotas' => $diferencia, 'preciou' => $montoPago['monto']];
                $montoInteresAtrasado += $this->calculoPotenciaColegio($diferencia, $porcentajeInteres, $montoPago['auxilio'], $dif2);
            }
        }

        $query = "select importe from calculo_colegiado(" . $colegiado . ", '" . $fecha_hasta_donde_paga . "','02', '" . date('Y-m-d') . "') WHERE codigo='INT'";

        $users = DB::connection('sqlsrv')->select($query);
        $colegiadoR = null;
        foreach ($users as $colegiado1) {
            $colegiadoR = $colegiado1;
        }
        $inte = 0;
        if ($colegiadoR) {
            $inte = $colegiadoR->importe;
        }


        $query = "select * from calculo_colegiado(" . $colegiado . ", '" . $fecha_hasta_donde_paga . "','02', '" . date('Y-m-d') . "') WHERE codigo!='INT'";

        $users = DB::connection('sqlsrv')->select($query);
        $colegiadoR1 = null;
        $detalleMontos = [];
        $capitalT = 0;
        foreach ($users as $colegiado2) {
            $colegiadoR = $colegiado2;
            $detalleMontos[] = ['codigo' => $colegiado2->codigo, 'cuotas' => $colegiado2->cantidad, 'preciou' => $colegiado2->precio];
            $capitalT += $colegiado2->cantidad * $colegiado2->precio;
        }

        $totalMontoColegio += ($mesesTemp - ($mesesDesdeTemp > 0 ? $mesesDesdeTemp : 0)) * 115.75;
        $total = $totalMontoColegio + $montoInteresAtrasado;
        $total = $capitalT + $inte;

        return array("montoInteres" => round($inte, 2), "cuotas" => $cuotasD, 'capitalColegio' => $capitalT, 'totalColegio' => round($total, 2), 'detalleMontos' => $detalleMontos);
        //        return array("montoInteres" => round($inte, 2), "cuotas" => $cuotasD, 'capitalColegio' => $totalMontoColegio, 'totalColegio' => round($total,2), 'detalleMontos' => $detalleMontos);
    }

    private function calculoPotenciaColegio($cuotasAtrasadas, $porcentajeInteres, $montoBase, $dif2)
    {
        $suma = 0;
        for ($i = 1; $i < $cuotasAtrasadas + 1; $i++) {
            $suma += pow(1 + $porcentajeInteres / 1000, $dif2 - $i);
        }
        $suma = $montoBase * ($suma - $cuotasAtrasadas);
        return $suma;
    }
    public function envioReciboElectronico($identificacion,$tipo,$recibo,$correo){
        $reciboMaestro = \App\Recibo_Maestro::where('numero_recibo', $recibo)->first();

        //Esta consulta nos devuelve los datos para generar el recibo electronico
        $query1 = "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total, tp.categoria_id, rd.id_mes, rd.año
        FROM sigecig_recibo_detalle rd
        INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
        WHERE rd.numero_recibo = $recibo";

         $datos = DB::select($query1);
         foreach ($datos as $key => $dato) {
            $tipoPago = \App\TipoDePago::where('codigo',$dato->codigo_compra)->first();
         if ($dato->categoria_id == 1) {
         $dato->tipo_de_pago = $dato->tipo_de_pago . ' No.';
         $numeroTimbres = \App\VentaDeTimbres::where('recibo_detalle_id', $dato->id)->get();
         $tamanioArrray = count($numeroTimbres) - 1;
         foreach ($numeroTimbres as $key => $numeroTimbre) {
         if ($dato->cantidad == 1) {
         $dato->tipo_de_pago = $dato->tipo_de_pago . ' ' . $numeroTimbre->numeracion_inicial;
         } else {
         $dato->tipo_de_pago = $dato->tipo_de_pago . ' ' . $numeroTimbre->numeracion_inicial . '-' . $numeroTimbre->numeracion_final;
         }
         }
         }
         if($tipoPago->id == 11){
            $mes = \App\SigecigMeses::where('id',$dato->id_mes)->first();
            $dato->tipo_de_pago = $dato->tipo_de_pago . ' (' . $mes->mes.' '.$dato->año.')';
        }

         }

         $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaRecibo/' . $recibo);
        //  $letras = NumeroALetras::convertir($reciboMaestro->monto_total, 'QUETZALES', 'CENTAVOS');

        $letra = new NumeroALetras;
        $letras = $letra->toMoney($reciboMaestro->monto_total, 2, 'QUETZALES', 'CENTAVOS');
         $pdf = \PDF::loadView('admin.correoRecibo.pdfRecibo', compact('reciboMaestro', 'datos', 'codigoQR', 'letras','tipo'))
         ->setPaper('legal', 'landscape');

         //envio de recibo por correo al colegiado
         $fecha_actual = date_format(Now(), 'd-m-Y');
         $infoCorreoRecibo = new \App\Mail\EnvioReciboElectronico($fecha_actual, $reciboMaestro, $tipo);
         $infoCorreoRecibo->subject('Recibo Electrónico No.' . $reciboMaestro->numero_recibo);
         $infoCorreoRecibo->from('cigenlinea@cig.org.gt', 'CIG');
         $infoCorreoRecibo->attachData($pdf->output(), '' . 'Recibo_' . $reciboMaestro->numero_recibo . '_' . $identificacion . '.pdf', ['mime' => 'application / pdf ']);
         Mail::to($correo)->send($infoCorreoRecibo);
        ////
    }

    public function guardarEstadoCuenta($id_maestro, $cantidad, $tipo_pago_id, $recibo_id, $abono, $cargo,$usuario_id, $mes, $año){
        $servicio = \App\TipoDePago::where('codigo',$tipo_pago_id)->first();
        $cuentaDetalle = new \App\EstadoDeCuentaDetalle;
        $cuentaDetalle->estado_cuenta_maestro_id = $id_maestro;
        $cuentaDetalle->cantidad = $cantidad;
        $cuentaDetalle->tipo_pago_id = $servicio->id;
        $cuentaDetalle->recibo_id = $recibo_id;
        $cuentaDetalle->abono = $abono;
        $cuentaDetalle->cargo = $cargo;
        $cuentaDetalle->usuario_id = $usuario_id;
        if($servicio->id == 11){
            $cuentaDetalle->id_mes = $mes;
            $cuentaDetalle->año = $año;
        }
        $cuentaDetalle->estado_id = '1';
        $cuentaDetalle->save();

    }
}

