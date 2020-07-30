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
use App\PosCobro;
use App\Banco;
use App\VentaDeTimbres;
use Validator;
//use NumeroALetras;
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
        $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 1)->orWhere('categoria_id', '=', 6)->orWhere('categoria_id', '=', 7)->get(); //el estado "0" son los tipo de pago activos
        $pos = PosCobro::all();
        $banco = Banco::all();
        return view('admin.creacionRecibo.index', compact('pos', 'tipo', 'banco'));
    }

    public function pdfRecibo(Recibo_Maestro $id)
    {
        $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaRecibo/' . $id->numero_recibo); //link para colegiados
        // $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaReciboGeneral/'.$id->numero_recibo); //link para Particulares y Empresa
        $letras = new NumeroALetras;
        $letras->toMoney($id->monto_total, 2, 'QUETZALES', 'CENTAVOS');
        $nit_ = SQLSRV_Colegiado::where("c_cliente", $id->numero_de_identificacion)->get()->first();
        $query1= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
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
        $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '!=', 1)->get();
        return json_encode($tipo);
    }

    public function SerieDePagoB($id)
    {
        $tipo = TipoDePago::where('estado', '=', 0)->where('categoria_id', '=', 1)->orWhere('categoria_id', '=', 6)->orWhere('categoria_id', '=', 7)->get();
        return json_encode($tipo);
    }

    public function consultaTimbres(Request $request)
    {
        //asignando otro valor a los tipos de pago
        if ($request->nombre == 'TC01'){$nombre2 = 'TIM1';$nombre3 = 'TE01';}
        if ($request->nombre == 'TC05'){$nombre2 = 'TIM5';$nombre3 = 'TE05';}
        if ($request->nombre == 'TC10'){$nombre2 = 'TIM10';$nombre3 = 'TE10';}
        if ($request->nombre == 'TC20'){$nombre2 = 'TIM20';$nombre3 = 'TE20';}
        if ($request->nombre == 'TC50'){$nombre2 = 'TIM50';$nombre3 = 'TE50';}
        if ($request->nombre == 'TC100'){$nombre2 = 'TIM100';$nombre3 = 'TE100';}
        if ($request->nombre == 'TC200'){$nombre2 = 'TIM200';$nombre3 = 'TE200';}
        if ($request->nombre == 'TC500'){$nombre2 = 'TIM500';$nombre3 = 'TE500';}

        // consulta para saber a que bodega pertenece el cajero o usuario loggeado
        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $request->user";
            $result = DB::select($query);
        $bodega = $result[0]->bodega;

        // consulta para saber la cantidad total de timbres por codigo de timbre y bodega
        $query = "SELECT SUM(cantidad) as cantidadTotal FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = $request->codigo AND bodega_id = $bodega";
        $result = DB::select($query);
        $cantidadTotal = $result[0]->cantidadTotal;

        if ($cantidadTotal >= $request->cantidad){ // si la existencia en bodega es mayor incia la operacion para desplegar dato de timbre
            $query = "SELECT * FROM sigecig_recibo_detalle WHERE codigo_compra LIKE '$request->nombre' OR codigo_compra LIKE '$nombre2' OR codigo_compra LIKE '$nombre3' ORDER BY id DESC";
            $result = DB::select($query);

            if ($result != null) {
                $id = $result[0]->id;

                $query = "SELECT * FROM sigecig_venta_de_timbres WHERE recibo_detalle_id = $id";
                $result = DB::select($query);
                $anteriorFinal = $result[0]->numeracion_final;

                $numeroInicio = $anteriorFinal + 1;
                $numeroFinal = $numeroInicio + $request->cantidad - 1;

                return array("numeroInicio" => $numeroInicio, "numeroFinal" => $numeroFinal);

            } else {
                $numeroInicio = 1;
                $numeroFinal = $numeroInicio + $request->cantidad - 1;

                return array("numeroInicio" => $numeroInicio, "numeroFinal" => $numeroFinal);
            }

            // return response()->json(['success' => 'Exito']);
        } else {
            $error = 'No hay existencia en su bodega para realizar esta venta';
            return response()->json($error, 500);
        }

        // consulta en phpMyAdmin para saber la existencia total de timbres por bodega y tipo de pago
        // SELECT SUM(cantidad) as cantidadTotal FROM `sigecig_ingreso_producto` WHERE tipo_de_pago_id = 30 AND bodega_id = 1

    }

    public function existenciaBodega(Request $request)
    {
        // consulta para saber a que bodega pertenece el cajero o usuario loggeado
        $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $request->user";
            $result = DB::select($query);
        $bodega = $result[0]->bodega;

        // consulta para saber la cantidad total de timbres por codigo de timbre y bodega
        $query = "SELECT SUM(cantidad) as cantidadTotal FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = $request->codigo AND bodega_id = $bodega";
        $result = DB::select($query);
        $cantidadTotal = $result[0]->cantidadTotal;

        return $cantidadTotal;
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
            $mesesASumar        = $request->input("nuevaFechaColegio");
            $totalPrecioTimbre  = $request->totalPrecioTimbre;
            $banco_id           = $request->banco;

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

            for ($i = 1; $i < sizeof($array); $i++) {
                $reciboDetalle = Recibo_Detalle::create([
                    'numero_recibo'     => $reciboMaestro->numero_recibo,
                    'codigo_compra'     => $array[$i][1],
                    'cantidad'          => $array[$i][2],
                    'precio_unitario'   => substr($array[$i][3],2),
                    'total'             => substr($array[$i][5],2),
                ]);
                //agregamos el cobro a el estado de cueta ( cargo)
                $cuentaD = \App\EstadoDeCuentaDetalle::create([
                    'estado_cuenta_maestro_id'      => $id_estado_cuenta->id,
                    'cantidad'                      => $array[$i][2],
                    'tipo_pago_id'                  => $array[$i][0],
                    'recibo_id'                     => $reciboMaestro->numero_recibo,
                    'abono'                         => '0',
                    'cargo'                         => substr($array[$i][5],2),
                    'usuario_id'                    => '1',
                    'estado_id'                     => '1',
                ]);
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

            //Envio de correo creacion de recibo colegiado
            $query1= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
            FROM sigecig_recibo_detalle rd
            INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
            WHERE rd.numero_recibo = $reciboMaestro->numero_recibo";

            $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaRecibo/' . $reciboMaestro->numero_recibo);
            $datos = DB::select($query1);
            $id = Recibo_Maestro::where("numero_recibo", $reciboMaestro['numero_recibo'])->get()->first();
            $letras = new NumeroALetras;
            $letras->toMoney($id->monto_total, 2, 'QUETZALES', 'CENTAVOS');
            $nit = SQLSRV_Colegiado::select('nit')->where('c_cliente', $colegiado)->get();
            $nit_ = $nit[0];
            $rdetalle1 = Recibo_Detalle::where('numero_recibo', $reciboMaestro['numero_recibo'])->get();
            $pdf = \PDF::loadView('admin.creacionRecibo.pdfrecibo', compact('id', 'nit_', 'datos', 'codigoQR', 'letras'))
                ->setPaper('legal', 'landscape');
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $datos_colegiado = SQLSRV_Colegiado::select('e_mail', 'n_cliente')->where('c_cliente', $colegiado)->get();
            try {
                $infoCorreoRecibo = new \App\Mail\EnvioReciboElectronico($fecha_actual, $datos_colegiado, $reciboMaestro, $tipoDeCliente);
                $infoCorreoRecibo->subject('Recibo Electrónico No.' . $reciboMaestro['numero_recibo']);
                $infoCorreoRecibo->from('cigenlinea@cig.org.gt', 'CIG');
                $infoCorreoRecibo->attachData($pdf->output(),''.'Recibo_'.$reciboMaestro['numero_recibo'].'_'.$colegiado.'.pdf', ['mime' => 'application / pdf ']);
                Mail::to($datos_colegiado[0]->e_mail)->send($infoCorreoRecibo);

                return response()->json(['success' => 'Todo Correcto']);
            } catch (\Throwable $th) {
                return response()->json(['success' => 'Exito-No se envio correo']);
            }


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
            $banco_id            = $request->banco;

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

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request);

            $reciboMaestro = $reciboMaestroP;

            //Envio de correo creacion de recibo Particular

            $query1= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
            FROM sigecig_recibo_detalle rd
            INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
            WHERE rd.numero_recibo = $reciboMaestro->numero_recibo";
            $datos = DB::select($query1);
            $id = Recibo_Maestro::where("numero_recibo", $reciboMaestro['numero_recibo'])->get()->first();
            $nit_ = $id;
            $letras = new NumeroALetras;
            $letras->toMoney($id->monto_total, 2, 'QUETZALES', 'CENTAVOS');
            $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaReciboGeneral/' . $reciboMaestro->numero_recibo);
            $pdf = \PDF::loadView('admin.creacionRecibo.pdfrecibo', compact('id', 'nit_', 'datos', 'codigoQR', 'letras'))
                ->setPaper('legal', 'landscape');
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $datos_colegiado = $id;
            try {
                $infoCorreoRecibo = new \App\Mail\EnvioReciboElectronico($fecha_actual, $datos_colegiado, $reciboMaestro, $tipoDeCliente);
                $infoCorreoRecibo->subject('Recibo Electrónico No.' . $reciboMaestro['numero_recibo']);
                $infoCorreoRecibo->from('cigenlinea@cig.org.gt', 'CIG');
                $infoCorreoRecibo->attachData($pdf->output(),''.'Recibo_'.$reciboMaestro['numero_recibo'].'.pdf', ['mime' => 'application / pdf ']);

                Mail::to($reciboMaestro->e_mail)->send($infoCorreoRecibo);

                return response()->json(['success' => 'Exito']);
            } catch (\Throwable $th) {
                return response()->json(['success' => 'Exito']);
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
            $banco_id            = $request->banco;

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
                $reciboDetalleE = Recibo_Detalle::create([
                    'numero_recibo'     => $reciboMaestroE->numero_recibo,
                    'codigo_compra'     => $array[$i][1],
                    'cantidad'          => $array[$i][2],
                    'precio_unitario'   => substr($array[$i][3],2),
                    'total'             => substr($array[$i][5],2),
                ]);
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

            $almacenDatosTimbre = $this->AlmacenDatosTimbre($request);

            //Envio de correo creacion de recibo Empresa

            $reciboMaestro =  $reciboMaestroE;
            $query1= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
            FROM sigecig_recibo_detalle rd
            INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
            WHERE rd.numero_recibo = $reciboMaestro->numero_recibo";
            $datos = DB::select($query1);

            $id = Recibo_Maestro::where("numero_recibo", $reciboMaestro['numero_recibo'])->get()->first();
            $nit = SQLSRV_Empresa::select('e_mail', 'EMPRESA','NIT')->where('CODIGO', $nit)->get();
            $nit_ = $nit[0];

            $letras = new NumeroALetras;
            $letras->toMoney($id->monto_total, 2, 'QUETZALES', 'CENTAVOS');
            $codigoQR = QrCode::format('png')->size(100)->generate('https://www2.cig.org.gt/constanciaReciboGeneral/' . $reciboMaestro->numero_recibo);
            $pdf = \PDF::loadView('admin.creacionRecibo.pdfrecibo', compact('id', 'nit_', 'datos', 'codigoQR', 'letras'))
                ->setPaper('legal', 'landscape');
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $datos_colegiado = $nit;
            try {
                $infoCorreoRecibo = new \App\Mail\EnvioReciboElectronico($fecha_actual, $datos_colegiado, $reciboMaestro, $tipoDeCliente);
                $infoCorreoRecibo->subject('Recibo Electrónico No.' . $reciboMaestro['numero_recibo']);
                $infoCorreoRecibo->from('cigenlinea@cig.org.gt', 'CIG');
                $infoCorreoRecibo->attachData($pdf->output(),''.'Recibo_'.$reciboMaestro['numero_recibo'].'_'.$nit[0]->NIT.'.pdf', ['mime' => 'application / pdf ']);

                Mail::to($datos_colegiado[0]->e_mail)->send($infoCorreoRecibo);

            } catch (\Throwable $th) {
                return response()->json(['success' => 'Exito']);
            }

        }
    }

    public function AlmacenDatosTimbre($request)
    {
        $tc01      = $request->input("config.tc01");
            if ($tc01 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc01inicio     = $request->input("config.tc01inicio");
                $tc01fin        = $request->input("config.tc01fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc01inicio;
                $insert->numeracion_final = $tc01fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 30 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC01' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM1' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE01'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
                    }
                }
            }

            $tc05      = $request->input("config.tc05");
            if ($tc05 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc05inicio     = $request->input("config.tc05inicio");
                $tc05fin        = $request->input("config.tc05fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc05inicio;
                $insert->numeracion_final = $tc05fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 31 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC05' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM5' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE05'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
                    }
                }
            }

            $tc10      = $request->input("config.tc10");
            if ($tc10 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc10inicio     = $request->input("config.tc10inicio");
                $tc10fin        = $request->input("config.tc10fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc10inicio;
                $insert->numeracion_final = $tc10fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 32 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM10' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE10'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
                    }
                }
            }

            $tc20      = $request->input("config.tc20");
            if ($tc20 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc20inicio     = $request->input("config.tc20inicio");
                $tc20fin        = $request->input("config.tc20fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc20inicio;
                $insert->numeracion_final = $tc20fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 34 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM20' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE20'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
                    }
                }
            }

            $tc50      = $request->input("config.tc50");
            if ($tc50 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc50inicio     = $request->input("config.tc50inicio");
                $tc50fin        = $request->input("config.tc50fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc50inicio;
                $insert->numeracion_final = $tc50fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 36 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM50' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE50'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
                    }
                }
            }

            $tc100      = $request->input("config.tc100");
            if ($tc100 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc100inicio     = $request->input("config.tc100inicio");
                $tc100fin        = $request->input("config.tc100fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc100inicio;
                $insert->numeracion_final = $tc100fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 33 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM100' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE100'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
                    }
                }
            }

            $tc200      = $request->input("config.tc200");
            if ($tc200 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc200inicio     = $request->input("config.tc200inicio");
                $tc200fin        = $request->input("config.tc200fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc200inicio;
                $insert->numeracion_final = $tc200fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 35 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM200' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE200'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
                    }
                }
            }

            $tc500      = $request->input("config.tc500");
            if ($tc500 != null){
                $lastValue = Recibo_Maestro::pluck('numero_recibo')->last();
                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                $result = DB::select($query);
                $id = $result[0]->id;
                $tc500inicio     = $request->input("config.tc500inicio");
                $tc500fin        = $request->input("config.tc500fin");

                $insert = new VentaDeTimbres;
                $insert->recibo_detalle_id = $id;
                $insert->numeracion_inicial = $tc500inicio;
                $insert->numeracion_final = $tc500fin;
                $insert->save();

                $user = $request->input("config.rol_user");
                $query = "SELECT bodega FROM sigecig_cajas WHERE cajero = $user";
                    $result = DB::select($query);
                $bodega = $result[0]->bodega;

                $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 37 AND bodega_id = $bodega ORDER BY id ASC";
                $result = DB::select($consulta);

                $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $lastValue AND codigo_compra LIKE 'TC500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TIM500' OR numero_recibo = $lastValue AND codigo_compra LIKE 'TE500'";
                $dato = DB::select($query);
                $cantidad = $dato[0]->cantidad;

                foreach($result as $res)
                {
                    $total = $res->cantidad - $cantidad;
                    if ($total >= 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                        $parametros = array(':total' => $total, ':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);
                        break;
                    } elseif ($total < 0) {
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $cantidad = $total * -1 ;
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
}
