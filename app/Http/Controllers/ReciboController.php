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
use App\Recibo_Maestro;
use App\Recibo_Detalle;
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
            $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '!=', 1)->get();
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

    public function consultaTimbres(Request $request)
    {
        // consulta para saber a que bodega pertenece el cajero o usuario loggeado
        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $request->user";
            $result = DB::select($query);

        if (empty($result)){
            $error = 'Usuario no cuenta con bodega asignada';
            return response()->json($error, 500);
        }else { $bodega = $result[0]->bodega; }

        // consulta para saber que codigo de timbre corresponde el tipo de pago
        $consulta = TiposDeProductos::select('timbre_id')->where('tipo_de_pago_id', $request->codigo)->get()->first();

        // consulta para saber la cantidad total de timbres por codigo de timbre y bodega
        $query = "SELECT SUM(cantidad) as cantidadTotal FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega";
        $result = DB::select($query);
        $cantidadTotal = $result[0]->cantidadTotal;

        if ($cantidadTotal >= $request->cantidad){ // si la existencia en bodega es mayor inicia la operacion para desplegar dato de timbre

            $consulta1 = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega AND cantidad != 0 ORDER BY id ASC";
            $result = DB::select($consulta1);

            foreach($result as $res)
            {
                $cant1 = $res->cantidad;
                $total = $res->cantidad - $request->cantidad;
                if ($total >= 0) {
                    $numeroInicio1 = $res->numeracion_inicial;
                    $numeroFinal1 = $res->numeracion_inicial + $request->cantidad - 1;
                    return array("numeroInicio1" => $numeroInicio1, "numeroFinal1" => $numeroFinal1, "cantidadDatos" => "1", "cantidad" => $request->cantidad);
                } elseif ($total < 0) {
                    $numeroInicio1 = $res->numeracion_inicial;
                    $numeroFinal1 = $res->numeracion_final;
                    $cantidad = $total * -1;

                    $consulta2 = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega AND cantidad != 0 ORDER BY id ASC";
                        $dato = DB::select($consulta2);

                    for($i = 1; $i < sizeof($dato); $i++)
                    {
                        $total = $dato[$i]->cantidad - $cantidad;
                        if ($total >= 0) {
                            $numeroInicio2 = $dato[$i]->numeracion_inicial;
                            $numeroFinal2 = $dato[$i]->numeracion_inicial + $cantidad - 1;
                            return array("numeroInicio1" => $numeroInicio1, "numeroFinal1" => $numeroFinal1, "cantidad" => $cant1, "cantidad2" => $cantidad, "numeroInicio2" => $numeroInicio2, "numeroFinal2" => $numeroFinal2,"cantidadDatos" => "2");
                        } elseif ($total < 0) {
                            $cant2 = $cantidad;
                            $numeroInicio2 = $dato[$i]->numeracion_inicial;
                            $numeroFinal2 = $dato[$i]->numeracion_final;
                            $cantidad = $total * -1;
                            $consulta3 = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega AND cantidad != 0 ORDER BY id ASC";
                                $dato = DB::select($consulta3);
                            for($i = 2; $i < sizeof($dato); $i++)
                            {
                                $total = $dato[$i]->cantidad - $cantidad;
                                if ($total >= 0) {
                                    $numeroInicio3 = $dato[$i]->numeracion_inicial;
                                    $numeroFinal3 = $dato[$i]->numeracion_inicial + $cantidad - 1;
                                    return array("cantidad" => $cant1, "cantidad2" => $cant2, "cantidad3" => $cantidad, "numeroInicio1" => $numeroInicio1, "numeroFinal1" => $numeroFinal1, "numeroInicio2" => $numeroInicio2, "numeroFinal2" => $numeroFinal2,"numeroInicio3" => $numeroInicio3, "numeroFinal3" => $numeroFinal3, "cantidadDatos" => "3");
                                } elseif ($total < 0) {
                                    $cantidad = $total * -1;
                                    $consulta4 = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = $consulta->timbre_id AND bodega_id = $bodega ORDER BY id ASC";
                                        $dato = DB::select($consulta4);
                                    for($i = 3; $i < sizeof($dato); $i++)
                                    {
                                        $total = $dato[$i]->cantidad - $cantidad;
                                        if ($total >= 0) {
                                            $numeroFinal = $dato[$i]->numeracion_inicial + $cantidad - 1;
                                            return array("numeroInicio" => $numeroInicio, "numeroFinal" => $numeroFinal);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $error = 'No hay existencia en su bodega para realizar esta venta';
            return response()->json($error, 500);
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
            $colegiado          = $request->input("config.c_cliente");
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
                        }
                    }
                    //agregamos el cobro a el estado de cueta ( cargo)
                    $tipoPago= \App\TipoDePago::where('id',$array[$i][0])->get()->first();
                    if($tipoPago->tipo != 1){
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $array[$i][2],
                        'tipo_pago_id'                  => $array[$i][0],
                        'recibo_id'                     => $reciboMaestro->numero_recibo,
                        'abono'                         => '0',
                        'cargo'                         => substr($array[$i][5],2),
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);}
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $array[$i][2],
                        'tipo_pago_id'                  => $array[$i][0],
                        'recibo_id'                     => $reciboMaestro->numero_recibo,
                        'abono'                         => substr($array[$i][5],2),
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
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

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request);
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
            $reciboMaestroP->usuario = Auth::user()->id;
            $reciboMaestroP->monto_total = $totalAPagarP;
            $reciboMaestroP->e_mail = $request->input("config.emailp");
            $reciboMaestroP->save();

            $array = $request->input("datos");

            for ($i = 1; $i < sizeof($array); $i++) {
                $reciboDetalleP = Recibo_Detalle::create([
                    'numero_recibo'     => $reciboMaestroP->numero_recibo,
                    'codigo_compra'     => $array[$i][1],
                    'cantidad'          => $array[$i][2],
                    'precio_unitario'   => substr($array[$i][3],2),
                    'total'             => substr($array[$i][5],2),
                ]);
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

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request);



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

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request);



               try {
                $empresa1 = SQLSRV_Empresa::select('e_mail', 'EMPRESA','NIT')->where('CODIGO', $nit)->get();
                $this-> envioReciboElectronico($nit,$tipoDeCliente,$reciboMaestroE->numero_recibo,$empresa1[0]->e_mail);

                return response()->json(['success' => 'Exito-Correo Enviado']);
                } catch (\Throwable $th) {
                    return response()->json(['success' => 'Exito- No se pudo enviar el correo electronico']);
                }


        }
    }

    public function AlmacenDatosTimbre($request)
    {
        $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
        $colegiado = $request->input("config.c_cliente");
        $tc01      = $request->input("config.tc01");
            if ($tc01 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc01");
                $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM1'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM1',
                                    'cantidad'          => $request->input("config.tmCantTc01"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM1',
                                    'cantidad'          => $request->input("config.tmCantTc01"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM1',
                                    'cantidad'          => $request->input("config.tmCantTc01_2"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM1',
                                    'cantidad'          => $request->input("config.tmCantTc01"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM1',
                                    'cantidad'          => $request->input("config.tmCantTc01_2"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM1',
                                    'cantidad'          => $request->input("config.tmCantTc01_3"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE01'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE01',
                                    'cantidad'          => $request->input("config.tmCantTc01"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE01',
                                    'cantidad'          => $request->input("config.tmCantTc01"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE01',
                                    'cantidad'          => $request->input("config.tmCantTc01_2"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE01',
                                    'cantidad'          => $request->input("config.tmCantTc01"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE01',
                                    'cantidad'          => $request->input("config.tmCantTc01_2"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE01',
                                    'cantidad'          => $request->input("config.tmCantTc01_3"),
                                    'precio_unitario'   => 1,
                                    'total'             => 1 * $request->input("config.tmCantTc01_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc01") + $request->input("config.tmCantTc01_2") + $request->input("config.tmCantTc01_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC01',
                            'cantidad'          => $request->input("config.tmCantTc01"),
                            'precio_unitario'   => 1,
                            'total'             => 1 * $request->input("config.tmCantTc01"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC01',
                            'cantidad'          => $request->input("config.tmCantTc01"),
                            'precio_unitario'   => 1,
                            'total'             => 1 * $request->input("config.tmCantTc01"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC01',
                            'cantidad'          => $request->input("config.tmCantTc01_2"),
                            'precio_unitario'   => 1,
                            'total'             => 1 * $request->input("config.tmCantTc01_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC01',
                            'cantidad'          => $request->input("config.tmCantTc01"),
                            'precio_unitario'   => 1,
                            'total'             => 1 * $request->input("config.tmCantTc01"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC01',
                            'cantidad'          => $request->input("config.tmCantTc01_2"),
                            'precio_unitario'   => 1,
                            'total'             => 1 * $request->input("config.tmCantTc01_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC01',
                            'cantidad'          => $request->input("config.tmCantTc01_3"),
                            'precio_unitario'   => 1,
                            'total'             => 1 * $request->input("config.tmCantTc01_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 30,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 1 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
                }

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc01inicio");
                    $insert->numeracion_final = $request->input("config.tc01fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc01inicio");
                    $insert->numeracion_final = $request->input("config.tc01fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc01inicio2");
                    $insert->numeracion_final = $request->input("config.tc01fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc01inicio");
                    $insert->numeracion_final = $request->input("config.tc01fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc01inicio2");
                    $insert->numeracion_final = $request->input("config.tc01fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc01inicio3");
                    $insert->numeracion_final = $request->input("config.tc01fin3");
                    $insert->save();
                }

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 1 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
                        }
                    }
                }
            }

            $tc05      = $request->input("config.tc05");
            if ($tc05 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc05");
                    $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM5'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM5',
                                    'cantidad'          => $request->input("config.tmCantTc05"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM5',
                                    'cantidad'          => $request->input("config.tmCantTc05"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM5',
                                    'cantidad'          => $request->input("config.tmCantTc05_2"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM5',
                                    'cantidad'          => $request->input("config.tmCantTc05"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM5',
                                    'cantidad'          => $request->input("config.tmCantTc05_2"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM5',
                                    'cantidad'          => $request->input("config.tmCantTc05_3"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE05'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE05',
                                    'cantidad'          => $request->input("config.tmCantTc05"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE05',
                                    'cantidad'          => $request->input("config.tmCantTc05"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE05',
                                    'cantidad'          => $request->input("config.tmCantTc05_2"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE05',
                                    'cantidad'          => $request->input("config.tmCantTc05"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE05',
                                    'cantidad'          => $request->input("config.tmCantTc05_2"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE05',
                                    'cantidad'          => $request->input("config.tmCantTc05_3"),
                                    'precio_unitario'   => 5,
                                    'total'             => 5 * $request->input("config.tmCantTc05_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc05") + $request->input("config.tmCantTc05_2") + $request->input("config.tmCantTc05_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC05',
                            'cantidad'          => $request->input("config.tmCantTc05"),
                            'precio_unitario'   => 5,
                            'total'             => 5 * $request->input("config.tmCantTc05"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC05',
                            'cantidad'          => $request->input("config.tmCantTc05"),
                            'precio_unitario'   => 5,
                            'total'             => 5 * $request->input("config.tmCantTc05"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC05',
                            'cantidad'          => $request->input("config.tmCantTc05_2"),
                            'precio_unitario'   => 5,
                            'total'             => 5 * $request->input("config.tmCantTc05_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC05',
                            'cantidad'          => $request->input("config.tmCantTc05"),
                            'precio_unitario'   => 5,
                            'total'             => 5 * $request->input("config.tmCantTc05"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC05',
                            'cantidad'          => $request->input("config.tmCantTc05_2"),
                            'precio_unitario'   => 5,
                            'total'             => 5 * $request->input("config.tmCantTc05_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC05',
                            'cantidad'          => $request->input("config.tmCantTc05_3"),
                            'precio_unitario'   => 5,
                            'total'             => 5 * $request->input("config.tmCantTc05_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 31,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 5 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
                }

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc05inicio");
                    $insert->numeracion_final = $request->input("config.tc05fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc05inicio");
                    $insert->numeracion_final = $request->input("config.tc05fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc05inicio2");
                    $insert->numeracion_final = $request->input("config.tc05fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc05inicio");
                    $insert->numeracion_final = $request->input("config.tc05fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc05inicio2");
                    $insert->numeracion_final = $request->input("config.tc05fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc05inicio3");
                    $insert->numeracion_final = $request->input("config.tc05fin3");
                    $insert->save();
                }


                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 2 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
                        }
                    }
                }
            }

            $tc10      = $request->input("config.tc10");
            if ($tc10 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc10");
                    $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM10'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM10',
                                    'cantidad'          => $request->input("config.tmCantTc10"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM10',
                                    'cantidad'          => $request->input("config.tmCantTc10"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM10',
                                    'cantidad'          => $request->input("config.tmCantTc10_2"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM10',
                                    'cantidad'          => $request->input("config.tmCantTc10"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM10',
                                    'cantidad'          => $request->input("config.tmCantTc10_2"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM10',
                                    'cantidad'          => $request->input("config.tmCantTc10_3"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE10'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE10',
                                    'cantidad'          => $request->input("config.tmCantTc10"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE10',
                                    'cantidad'          => $request->input("config.tmCantTc10"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE10',
                                    'cantidad'          => $request->input("config.tmCantTc10_2"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE10',
                                    'cantidad'          => $request->input("config.tmCantTc10"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE10',
                                    'cantidad'          => $request->input("config.tmCantTc10_2"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE10',
                                    'cantidad'          => $request->input("config.tmCantTc10_3"),
                                    'precio_unitario'   => 10,
                                    'total'             => 10 * $request->input("config.tmCantTc10_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc10") + $request->input("config.tmCantTc10_2") + $request->input("config.tmCantTc10_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC10',
                            'cantidad'          => $request->input("config.tmCantTc10"),
                            'precio_unitario'   => 10,
                            'total'             => 10 * $request->input("config.tmCantTc10"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC10',
                            'cantidad'          => $request->input("config.tmCantTc10"),
                            'precio_unitario'   => 10,
                            'total'             => 10 * $request->input("config.tmCantTc10"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC10',
                            'cantidad'          => $request->input("config.tmCantTc10_2"),
                            'precio_unitario'   => 10,
                            'total'             => 10 * $request->input("config.tmCantTc10_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC10',
                            'cantidad'          => $request->input("config.tmCantTc10"),
                            'precio_unitario'   => 10,
                            'total'             => 10 * $request->input("config.tmCantTc10"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC10',
                            'cantidad'          => $request->input("config.tmCantTc10_2"),
                            'precio_unitario'   => 10,
                            'total'             => 10 * $request->input("config.tmCantTc10_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC10',
                            'cantidad'          => $request->input("config.tmCantTc10_3"),
                            'precio_unitario'   => 10,
                            'total'             => 10 * $request->input("config.tmCantTc10_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 32,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 10 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
                }

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc10inicio");
                    $insert->numeracion_final = $request->input("config.tc10fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc10inicio");
                    $insert->numeracion_final = $request->input("config.tc10fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc10inicio2");
                    $insert->numeracion_final = $request->input("config.tc10fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc10inicio");
                    $insert->numeracion_final = $request->input("config.tc10fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc10inicio2");
                    $insert->numeracion_final = $request->input("config.tc10fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc10inicio3");
                    $insert->numeracion_final = $request->input("config.tc10fin3");
                    $insert->save();
                }

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 3 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
                        }
                    }
                }
            }

            $tc20      = $request->input("config.tc20");
            if ($tc20 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc20");
                    $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM20'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM20',
                                    'cantidad'          => $request->input("config.tmCantTc20"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM20',
                                    'cantidad'          => $request->input("config.tmCantTc20"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM20',
                                    'cantidad'          => $request->input("config.tmCantTc20_2"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM20',
                                    'cantidad'          => $request->input("config.tmCantTc20"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM20',
                                    'cantidad'          => $request->input("config.tmCantTc20_2"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM20',
                                    'cantidad'          => $request->input("config.tmCantTc20_3"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE20'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE20',
                                    'cantidad'          => $request->input("config.tmCantTc20"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE20',
                                    'cantidad'          => $request->input("config.tmCantTc20"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE20',
                                    'cantidad'          => $request->input("config.tmCantTc20_2"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE20',
                                    'cantidad'          => $request->input("config.tmCantTc20"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE20',
                                    'cantidad'          => $request->input("config.tmCantTc20_2"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE20',
                                    'cantidad'          => $request->input("config.tmCantTc20_3"),
                                    'precio_unitario'   => 20,
                                    'total'             => 20 * $request->input("config.tmCantTc20_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc20") + $request->input("config.tmCantTc20_2") + $request->input("config.tmCantTc20_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC20',
                            'cantidad'          => $request->input("config.tmCantTc20"),
                            'precio_unitario'   => 20,
                            'total'             => 20 * $request->input("config.tmCantTc20"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC20',
                            'cantidad'          => $request->input("config.tmCantTc20"),
                            'precio_unitario'   => 20,
                            'total'             => 20 * $request->input("config.tmCantTc20"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC20',
                            'cantidad'          => $request->input("config.tmCantTc20_2"),
                            'precio_unitario'   => 20,
                            'total'             => 20 * $request->input("config.tmCantTc20_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC20',
                            'cantidad'          => $request->input("config.tmCantTc20"),
                            'precio_unitario'   => 20,
                            'total'             => 20 * $request->input("config.tmCantTc20"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC20',
                            'cantidad'          => $request->input("config.tmCantTc20_2"),
                            'precio_unitario'   => 20,
                            'total'             => 20 * $request->input("config.tmCantTc20_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC20',
                            'cantidad'          => $request->input("config.tmCantTc20_3"),
                            'precio_unitario'   => 20,
                            'total'             => 20 * $request->input("config.tmCantTc20_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 34,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 20 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
                }

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc20inicio");
                    $insert->numeracion_final = $request->input("config.tc20fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc20inicio");
                    $insert->numeracion_final = $request->input("config.tc20fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc20inicio2");
                    $insert->numeracion_final = $request->input("config.tc20fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc20inicio");
                    $insert->numeracion_final = $request->input("config.tc20fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc20inicio2");
                    $insert->numeracion_final = $request->input("config.tc20fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc20inicio3");
                    $insert->numeracion_final = $request->input("config.tc20fin3");
                    $insert->save();
                }

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 4 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
                        }
                    }
                }
            }

            $tc50      = $request->input("config.tc50");
            if ($tc50 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc50");
                    $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM50'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM50',
                                    'cantidad'          => $request->input("config.tmCantTc50"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM50',
                                    'cantidad'          => $request->input("config.tmCantTc50"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM50',
                                    'cantidad'          => $request->input("config.tmCantTc50_2"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM50',
                                    'cantidad'          => $request->input("config.tmCantTc50"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM50',
                                    'cantidad'          => $request->input("config.tmCantTc50_2"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM50',
                                    'cantidad'          => $request->input("config.tmCantTc50_3"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE50'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE50',
                                    'cantidad'          => $request->input("config.tmCantTc50"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE50',
                                    'cantidad'          => $request->input("config.tmCantTc50"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE50',
                                    'cantidad'          => $request->input("config.tmCantTc50_2"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE50',
                                    'cantidad'          => $request->input("config.tmCantTc50"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE50',
                                    'cantidad'          => $request->input("config.tmCantTc50_2"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE50',
                                    'cantidad'          => $request->input("config.tmCantTc50_3"),
                                    'precio_unitario'   => 50,
                                    'total'             => 50 * $request->input("config.tmCantTc50_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc50") + $request->input("config.tmCantTc50_2") + $request->input("config.tmCantTc50_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC50',
                            'cantidad'          => $request->input("config.tmCantTc50"),
                            'precio_unitario'   => 50,
                            'total'             => 50 * $request->input("config.tmCantTc50"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC50',
                            'cantidad'          => $request->input("config.tmCantTc50"),
                            'precio_unitario'   => 50,
                            'total'             => 50 * $request->input("config.tmCantTc50"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC50',
                            'cantidad'          => $request->input("config.tmCantTc50_2"),
                            'precio_unitario'   => 50,
                            'total'             => 50 * $request->input("config.tmCantTc50_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC50',
                            'cantidad'          => $request->input("config.tmCantTc50"),
                            'precio_unitario'   => 50,
                            'total'             => 50 * $request->input("config.tmCantTc50"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC50',
                            'cantidad'          => $request->input("config.tmCantTc50_2"),
                            'precio_unitario'   => 50,
                            'total'             => 50 * $request->input("config.tmCantTc50_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC50',
                            'cantidad'          => $request->input("config.tmCantTc50_3"),
                            'precio_unitario'   => 50,
                            'total'             => 50 * $request->input("config.tmCantTc50_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 36,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 50 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);

                }

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc50inicio");
                    $insert->numeracion_final = $request->input("config.tc50fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc50inicio");
                    $insert->numeracion_final = $request->input("config.tc50fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc50inicio2");
                    $insert->numeracion_final = $request->input("config.tc50fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc50inicio");
                    $insert->numeracion_final = $request->input("config.tc50fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc50inicio2");
                    $insert->numeracion_final = $request->input("config.tc50fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc50inicio3");
                    $insert->numeracion_final = $request->input("config.tc50fin3");
                    $insert->save();
                }

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 5 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
                        }
                    }
                }
            }

            $tc100      = $request->input("config.tc100");
            if ($tc100 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc100");
                    $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM100'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM100',
                                    'cantidad'          => $request->input("config.tmCantTc100"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM100',
                                    'cantidad'          => $request->input("config.tmCantTc100"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM100',
                                    'cantidad'          => $request->input("config.tmCantTc100_2"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM100',
                                    'cantidad'          => $request->input("config.tmCantTc100"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM100',
                                    'cantidad'          => $request->input("config.tmCantTc100_2"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM100',
                                    'cantidad'          => $request->input("config.tmCantTc100_3"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE100'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE100',
                                    'cantidad'          => $request->input("config.tmCantTc100"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE100',
                                    'cantidad'          => $request->input("config.tmCantTc100"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE100',
                                    'cantidad'          => $request->input("config.tmCantTc100_2"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE100',
                                    'cantidad'          => $request->input("config.tmCantTc100"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE100',
                                    'cantidad'          => $request->input("config.tmCantTc100_2"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE100',
                                    'cantidad'          => $request->input("config.tmCantTc100_3"),
                                    'precio_unitario'   => 100,
                                    'total'             => 100 * $request->input("config.tmCantTc100_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc100") + $request->input("config.tmCantTc100_2") + $request->input("config.tmCantTc100_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC100',
                            'cantidad'          => $request->input("config.tmCantTc100"),
                            'precio_unitario'   => 100,
                            'total'             => 100 * $request->input("config.tmCantTc100"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC100',
                            'cantidad'          => $request->input("config.tmCantTc100"),
                            'precio_unitario'   => 100,
                            'total'             => 100 * $request->input("config.tmCantTc100"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC100',
                            'cantidad'          => $request->input("config.tmCantTc100_2"),
                            'precio_unitario'   => 100,
                            'total'             => 100 * $request->input("config.tmCantTc100_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC100',
                            'cantidad'          => $request->input("config.tmCantTc100"),
                            'precio_unitario'   => 100,
                            'total'             => 100 * $request->input("config.tmCantTc100"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC100',
                            'cantidad'          => $request->input("config.tmCantTc100_2"),
                            'precio_unitario'   => 100,
                            'total'             => 100 * $request->input("config.tmCantTc100_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC100',
                            'cantidad'          => $request->input("config.tmCantTc100_3"),
                            'precio_unitario'   => 100,
                            'total'             => 100 * $request->input("config.tmCantTc100_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 33,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 100 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
                }

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc100inicio");
                    $insert->numeracion_final = $request->input("config.tc100fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc100inicio");
                    $insert->numeracion_final = $request->input("config.tc100fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc100inicio2");
                    $insert->numeracion_final = $request->input("config.tc100fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc100inicio");
                    $insert->numeracion_final = $request->input("config.tc100fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc100inicio2");
                    $insert->numeracion_final = $request->input("config.tc100fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc100inicio3");
                    $insert->numeracion_final = $request->input("config.tc100fin3");
                    $insert->save();
                }

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 6 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
                        }
                    }
                }
            }

            $tc200      = $request->input("config.tc200");
            if ($tc200 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc200");
                    $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM200'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM200',
                                    'cantidad'          => $request->input("config.tmCantTc200"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM200',
                                    'cantidad'          => $request->input("config.tmCantTc200"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM200',
                                    'cantidad'          => $request->input("config.tmCantTc200_2"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM200',
                                    'cantidad'          => $request->input("config.tmCantTc200"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM200',
                                    'cantidad'          => $request->input("config.tmCantTc200_2"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM200',
                                    'cantidad'          => $request->input("config.tmCantTc200_3"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE200'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE200',
                                    'cantidad'          => $request->input("config.tmCantTc200"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE200',
                                    'cantidad'          => $request->input("config.tmCantTc200"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE200',
                                    'cantidad'          => $request->input("config.tmCantTc200_2"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE200',
                                    'cantidad'          => $request->input("config.tmCantTc200"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE200',
                                    'cantidad'          => $request->input("config.tmCantTc200_2"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE200',
                                    'cantidad'          => $request->input("config.tmCantTc200_3"),
                                    'precio_unitario'   => 200,
                                    'total'             => 200 * $request->input("config.tmCantTc200_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc200") + $request->input("config.tmCantTc200_2") + $request->input("config.tmCantTc200_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC200',
                            'cantidad'          => $request->input("config.tmCantTc200"),
                            'precio_unitario'   => 200,
                            'total'             => 200 * $request->input("config.tmCantTc200"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC200',
                            'cantidad'          => $request->input("config.tmCantTc200"),
                            'precio_unitario'   => 200,
                            'total'             => 200 * $request->input("config.tmCantTc200"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC200',
                            'cantidad'          => $request->input("config.tmCantTc200_2"),
                            'precio_unitario'   => 200,
                            'total'             => 200 * $request->input("config.tmCantTc200_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC200',
                            'cantidad'          => $request->input("config.tmCantTc200"),
                            'precio_unitario'   => 200,
                            'total'             => 200 * $request->input("config.tmCantTc200"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC200',
                            'cantidad'          => $request->input("config.tmCantTc200_2"),
                            'precio_unitario'   => 200,
                            'total'             => 200 * $request->input("config.tmCantTc200_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC200',
                            'cantidad'          => $request->input("config.tmCantTc200_3"),
                            'precio_unitario'   => 200,
                            'total'             => 200 * $request->input("config.tmCantTc200_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 35,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 200 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
                }

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc200inicio");
                    $insert->numeracion_final = $request->input("config.tc200fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc200inicio");
                    $insert->numeracion_final = $request->input("config.tc200fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc200inicio2");
                    $insert->numeracion_final = $request->input("config.tc200fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc200inicio");
                    $insert->numeracion_final = $request->input("config.tc200fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc200inicio2");
                    $insert->numeracion_final = $request->input("config.tc200fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc200inicio3");
                    $insert->numeracion_final = $request->input("config.tc200fin3");
                    $insert->save();
                }

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 7 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
                        }
                    }
                }
            }

            $tc500      = $request->input("config.tc500");
            if ($tc500 != null){
                $id_estado_cuenta= \App\EstadoDeCuentaMaestro::where('colegiado_id',$colegiado)->get()->first();
                $cantidadDatos = $request->input("config.cantidadDatosTc500");
                    $array = $request->input("datos");

                    for ($i = 1; $i < sizeof($array); $i++) {
                        if ($array[$i][1] == 'TIM500'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM500',
                                    'cantidad'          => $request->input("config.tmCantTc500"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM500',
                                    'cantidad'          => $request->input("config.tmCantTc500"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM500',
                                    'cantidad'          => $request->input("config.tmCantTc500_2"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM500',
                                    'cantidad'          => $request->input("config.tmCantTc500"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM500',
                                    'cantidad'          => $request->input("config.tmCantTc500_2"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TIM500',
                                    'cantidad'          => $request->input("config.tmCantTc500_3"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500_3"),
                                ]);
                            }
                        }
                        if ($array[$i][1] == 'TE500'){
                            if ($cantidadDatos == '1'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE500',
                                    'cantidad'          => $request->input("config.tmCantTc500"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500"),
                                ]);
                            }
                            if ($cantidadDatos == '2'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE500',
                                    'cantidad'          => $request->input("config.tmCantTc500"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE500',
                                    'cantidad'          => $request->input("config.tmCantTc500_2"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500_2"),
                                ]);
                            }
                            if ($cantidadDatos == '3'){
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE500',
                                    'cantidad'          => $request->input("config.tmCantTc500"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE500',
                                    'cantidad'          => $request->input("config.tmCantTc500_2"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500_2"),
                                ]);
                                $reciboDetalle = Recibo_Detalle::create([
                                    'numero_recibo'     => $lastValue,
                                    'codigo_compra'     => 'TE500',
                                    'cantidad'          => $request->input("config.tmCantTc500_3"),
                                    'precio_unitario'   => 500,
                                    'total'             => 500 * $request->input("config.tmCantTc500_3"),
                                ]);
                            }
                        }
                    }
                    $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                    $result = DB::select($query);
                    if (sizeof($result) == 1){ $id1 = $result[0]->id; }
                    elseif (sizeof($result) == 2){ $id1 = $result[0]->id; $id2 = $result[1]->id; }
                    elseif (sizeof($result) == 3){ $id1 = $result[0]->id; $id2 = $result[1]->id; $id3 = $result[2]->id; }

                if (empty($result)) {
                    $totalCantidad = 0;
                    $totalCantidad = $request->input("config.tmCantTc500") + $request->input("config.tmCantTc500_2") + $request->input("config.tmCantTc500_3");
                    if ($cantidadDatos == '1'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC500',
                            'cantidad'          => $request->input("config.tmCantTc500"),
                            'precio_unitario'   => 500,
                            'total'             => 500 * $request->input("config.tmCantTc500"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                    }
                    if ($cantidadDatos == '2'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC500',
                            'cantidad'          => $request->input("config.tmCantTc500"),
                            'precio_unitario'   => 500,
                            'total'             => 500 * $request->input("config.tmCantTc500"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC500',
                            'cantidad'          => $request->input("config.tmCantTc500_2"),
                            'precio_unitario'   => 500,
                            'total'             => 500 * $request->input("config.tmCantTc500_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                    }
                    if ($cantidadDatos == '3'){
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC500',
                            'cantidad'          => $request->input("config.tmCantTc500"),
                            'precio_unitario'   => 500,
                            'total'             => 500 * $request->input("config.tmCantTc500"),
                        ]);
                        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                        $result = DB::select($query);
                        $id1 = $result[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC500',
                            'cantidad'          => $request->input("config.tmCantTc500_2"),
                            'precio_unitario'   => 500,
                            'total'             => 500 * $request->input("config.tmCantTc500_2"),
                        ]);
                        $query2 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                        $result2 = DB::select($query2);
                        $id2 = $result2[0]->id;
                        $reciboDetalle = Recibo_Detalle::create([
                            'numero_recibo'     => $lastValue,
                            'codigo_compra'     => 'TC500',
                            'cantidad'          => $request->input("config.tmCantTc500_3"),
                            'precio_unitario'   => 500,
                            'total'             => 500 * $request->input("config.tmCantTc500_3"),
                        ]);
                        $query3 = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                        $result3 = DB::select($query3);
                        $id3 = $result3[0]->id;
                    }
                    //agregamos el pago al estado de cuenta (abono)
                    $cuentaD = \App\EstadoDeCuentaDetalle::create([
                        'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                        'cantidad'                      => $totalCantidad,
                        'tipo_pago_id'                  => 35,
                        'recibo_id'                     => $lastValue,
                        'abono'                         => 500 * $totalCantidad,
                        'cargo'                         => '0',
                        'usuario_id'                    => '1',
                        'estado_id'                     => '1',
                    ]);
                }

                $cantidadDatos = $request->input("config.cantidadDatosTc500");

                if ($cantidadDatos == '1'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc500inicio");
                    $insert->numeracion_final = $request->input("config.tc500fin");
                    $insert->save();
                }
                if ($cantidadDatos == '2'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc500inicio");
                    $insert->numeracion_final = $request->input("config.tc500fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc500inicio2");
                    $insert->numeracion_final = $request->input("config.tc500fin2");
                    $insert->save();
                }
                if ($cantidadDatos == '3'){
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id1;
                    $insert->numeracion_inicial = $request->input("config.tc500inicio");
                    $insert->numeracion_final = $request->input("config.tc500fin");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id2;
                    $insert->numeracion_inicial = $request->input("config.tc500inicio2");
                    $insert->numeracion_final = $request->input("config.tc500fin2");
                    $insert->save();
                    $insert = new VentaDeTimbres;
                    $insert->recibo_detalle_id = $id3;
                    $insert->numeracion_inicial = $request->input("config.tc500inicio3");
                    $insert->numeracion_final = $request->input("config.tc500fin3");
                    $insert->save();
                }

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 8 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT SUM(cantidad) as cantidad FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    if ($res->cantidad != 0)
                    {
                        $total = $res->cantidad - $cantidad;
                        if ($total >= 0) {
                            if ($total == 0){
                                $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                                $parametros = array(':id' => $res->id );
                                $result = DB::connection('mysql')->update($query, $parametros);
                                break;
                            }
                            $nuevoInicio = $res->numeracion_inicial + $cantidad;
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                            $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicio );
                            $result = DB::connection('mysql')->update($query, $parametros);
                            break;
                        } elseif ($total < 0) {
                            $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                            $parametros = array(':id' => $res->id );
                            $result = DB::connection('mysql')->update($query, $parametros);

                            $cantidad = $total * -1 ;
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
         $numeroTimbres = \App\SegecigRegistroVentaTimbres::where('recibo_detalle_id', $dato->id)->get();
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
}

