<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ReportesController extends Controller
{
    public function reporteVentasXyz(Request $request){
        $user = Auth::User();
        $fechaInicial=Carbon::parse($request->fechaInicialVenta)->startOfDay()->toDateString();
        $fechaFinal=Carbon::parse($request->fechaFinalVenta)->endOfDay()->toDateString();

        $facturas=\App\SQLSRV_Fac01::select('num_fac','serie_f','total_fac','control','c_bodega')->whereBetween('fecha1', [$fechaInicial, $fechaFinal])->where('anulado','N')->where('c_bodega',$request->cajaActivaxyz)->get();
        $total = $facturas->sum('total_fac');
        $arrayDetalles = array();

            foreach ($facturas as $key => $factura) {
                        $query = "SELECT b.c_bodega, U.control, U.total_fac, U.c_cliente, b.n_bodega, U.serie_f,  U.num_fac, U.n_cliente,FORMAT( U.fecha1, 'dd/MM/yyyy h:m:s', 'en-US' ) AS 'fecha',S.descripcion ,
                        CONVERT(VARCHAR, CAST(S.importe  AS MONEY), 1) as importe,  CONVERT(VARCHAR, CAST(S.precio_u  AS MONEY), 1) as precio_u,
                        CONVERT(VARCHAR, CAST(S.cantidad  AS MONEY), 1) as cantidad,  S.codigo, V.n_vendedor, U.efectivo, U.tarjeta, U.cheque, S.codigo
                        FROM fac01 U
                        INNER JOIN fac02 S ON U.control =S.control
                        INNER JOIN vdor v ON V.c_vendedor = U.c_vendedor
                        INNER JOIN inv02 b ON b.c_bodega = U.c_bodega
                        WHERE   S.control = '$factura->control'
                        ORDER BY U.num_fac ASC";

                        $result = DB::connection('sqlsrv')->select($query);
               if(!empty($result)){
                $arrayDetalles[]=$result;
               }
            }
            return \PDF::loadView('admin.reportes.pdf-reporte-ventas-xyz',compact('arrayDetalles','fechaInicial','fechaFinal','user','total'))
            ->setPaper('legal', 'landscape')
            ->stream('Ventas.pdf');

    }

    public function reporteEnvios(Request $request){
        $user = Auth::User();
        $fechaInicial=Carbon::parse($request->fechaInicialEnvio)->startOfDay()->toDateString();
        $fechaFinal=Carbon::parse($request->fechaFinalEnvio)->endOfDay()->toDateString();
        // $facturas=\App\SQLSRV_Fac01::select('fecha1','serie_f','total_fac','control')->whereBetween('fecha1', [$fechaInicial, $fechaFinal])->get();

       $envios = \App\SQLSRV_Fac01::select('fac01.control', 'fac02.codigo','fac01.total_fac')
       ->join('fac02', 'fac01.control', '=', 'fac02.control')
       ->whereBetween('fac01.fecha1', [$fechaInicial, $fechaFinal])
       ->wherein('fac02.codigo', ['CORREOLOCAL1','CORREOZONA15'])
       ->orderBy('fac02.codigo','asc')
       ->get();

       $arrayDetalles = array();
       $total = $envios->sum('total_fac');


       foreach ($envios as $key => $envio) {
            $env = \App\SQLSRV_Fac01::select('fac01.control', 'fac02.codigo','inv02.n_bodega','vdor.n_vendedor','fac01.c_cliente'
            ,'fac01.n_cliente','fac02.descripcion','fac01.serie_f','fac01.num_fac','fac01.efectivo','fac01.cheque','fac01.tarjeta','fac02.importe'
            ,'fac02.precio_u','fac02.cantidad','fac01.fecha1','fac01.total_fac')
            ->join('fac02', 'fac01.control', '=', 'fac02.control')
            ->join('inv02', 'fac01.c_bodega', '=', 'inv02.c_bodega')
            ->join('vdor', 'fac01.c_vendedor', '=', 'vdor.c_vendedor')
            ->where('fac01.control',$envio->control)
            ->orderBy('fac02.codigo','asc')
            ->get();
            $arrayDetalles[]=$env;
       }
       return \PDF::loadView('admin.reportes.pdf-reporte-envios-xyz',compact('arrayDetalles','fechaInicial','fechaFinal','user','total'))
       ->setPaper('legal', 'landscape')
       ->stream('Envíos.pdf');





    }

    public function reporteColegiadosPorAnio(Request $request){
        $user = Auth::User();
        $newDate = now();
        $anio = $request->anio;
        $fechaInicial = '01/01/'.$request->anio;
        $fechaFinal = '12/31/'.$request->anio;
        $fechaInicial= \Carbon\Carbon::parse($fechaInicial)->format('Y-m-d H:i');
        $fechaFinal= \Carbon\Carbon::parse($fechaFinal)->format('Y-m-d H:i');

        $colegiados = \App\CC00::select('c_cliente','n_cliente','e_mail','f_creacion','f_ult_pago','f_ult_timbre','fecha_col')
        ->whereBetween('fecha_col', [$fechaInicial, $fechaFinal])->orderBy('f_creacion','asc')->get();

        if (sizeof($colegiados) > 0){
            foreach ($colegiados as $key => $cole){
                $query = "SELECT c.c_cliente colegiado, c.n_cliente nombre, CONVERT(VARCHAR(10),c.fecha_col,120) fechacolegiado,c.fax telefonotrabajo,
                c.telefono,c.e_mail,CONVERT(VARCHAR(10),c.f_ult_pago,120) fechaultimopagocolegio, CONVERT(VARCHAR(10),c.f_ult_timbre,120) fechaultimopagotimbre,
                CASE WHEN c.fallecido='S' THEN 'Fallecido' WHEN getdate() > c.topefechapagocuotas THEN 'Suspendido' WHEN (DATEDIFF(month, c.f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) THEN 'Activo' ELSE 'Inactivo' END AS status,
                c.monto_timbre montotimbre,convert(VARCHAR(max),c.titulo_tesis) titulotesis
                FROM cc00 c
                WHERE c_cliente = :colcol";
                $parametros = array(':colcol' => $cole->c_cliente);
                $users = DB::connection('sqlsrv')->select($query, $parametros);

                $profesion = \App\CC00prof::select('c_cliente','n_profesion')->where('c_cliente', $cole->c_cliente)->get();

                $prof[]=$profesion;
                $arrayDetalles[]=$users;
            }
            // set_time_limit(3000);
            return \PDF::loadView('admin.reportes.pdf-colegiados-por-anio',compact('arrayDetalles','anio','user','newDate', 'prof'))
            ->setPaper('legal', 'landscape')
            ->stream('Envíos.pdf');
        } else {
            return 'Cadena Vacia - No hay colegiados asociado es este año: '.$anio;
        }


    }

    public function reporteCursosCeduca(Request $request){

        $user = Auth::User();
        $newDate = now();

        if (intval($request->cursos) != 100000){
            $trayecto = 'UnCurso';
            $curso = \App\SQLSRV_Producto::where('id',$request->cursos)->get()->first();
            $datosFac02 = \App\SQLSRV_Fac02::select('control', 'serie_f', 'num_fac', 'codigo', 'descripcion', 'precio_u', 'cantidad', 'id')->where('codigo',$curso->codigo)->get();

            if (sizeof($datosFac02) > 0){
                foreach ($datosFac02 as $key => $envio) {
                    $env = \App\SQLSRV_Fac01::select('fac01.control', 'fac02.codigo','inv02.n_bodega','vdor.n_vendedor','fac01.c_cliente','cc00.telefono'
                    ,'fac01.n_cliente','fac02.descripcion','fac01.serie_f','fac01.num_fac','fac01.efectivo','fac01.cheque','fac01.tarjeta','cc00.e_mail'
                    ,'fac02.importe','fac02.precio_u','fac02.cantidad','fac01.fecha1','fac01.total_fac')
                    ->join('fac02', 'fac01.control', '=', 'fac02.control')
                    ->join('inv02', 'fac01.c_bodega', '=', 'inv02.c_bodega')
                    ->join('vdor', 'fac01.c_vendedor', '=', 'vdor.c_vendedor')
                    ->join('cc00', 'fac01.c_cliente', '=', 'cc00.c_cliente')
                    ->where('fac01.control',$envio->control)
                    ->where('fac01.serie_f',$envio->serie_f)
                    ->orderBy('fac02.codigo','asc')
                    ->get();
                    $arrayDetalles[]=$env;
                }

                return \PDF::loadView('admin.reportes.pdf-reporte-cursos-ceduca',compact('user','newDate','curso','datosFac02','arrayDetalles', 'trayecto'))
                ->setPaper('legal', 'landscape')
                ->stream('Envíos.pdf');
            } else {
                return 'Cadena Vacia - No hay colegiados inscritos en este curso';
            }
        } else {
            $trayecto = 'todos';
            $curso = \App\SQLSRV_Producto::where('categoria_id',2)->where('estado_id',0)->get();
            foreach ($curso as $cur){
                $datosFac02 = \App\SQLSRV_Fac02::select('control', 'serie_f', 'num_fac', 'codigo', 'descripcion', 'precio_u', 'cantidad', 'id')->where('codigo',$cur->codigo)->get();
                $detallesFac02[]=$datosFac02;
            }

            foreach ($detallesFac02 as $key => $envio) {
                foreach ($envio as $envi) {
                    $env = \App\SQLSRV_Fac01::select('fac01.control', 'fac02.codigo','inv02.n_bodega','vdor.n_vendedor','fac01.c_cliente','cc00.telefono'
                    ,'fac01.n_cliente','fac02.descripcion','fac01.serie_f','fac01.num_fac','fac01.efectivo','fac01.cheque','fac01.tarjeta','cc00.e_mail'
                    ,'fac02.importe','fac02.precio_u','fac02.cantidad','fac01.fecha1','fac01.total_fac')
                    ->join('fac02', 'fac01.control', '=', 'fac02.control')
                    ->join('inv02', 'fac01.c_bodega', '=', 'inv02.c_bodega')
                    ->join('vdor', 'fac01.c_vendedor', '=', 'vdor.c_vendedor')
                    ->join('cc00', 'fac01.c_cliente', '=', 'cc00.c_cliente')
                    ->where('fac01.control',$envi->control)
                    ->where('fac01.serie_f',$envi->serie_f)
                    ->orderBy('fac02.descripcion','asc')
                    ->get();
                    $arrayDetalles[]=$env;
                }
           }

            return \PDF::loadView('admin.reportes.pdf-reporte-cursos-ceduca',compact('user','newDate','curso','datosFac02','arrayDetalles', 'trayecto'))
            ->setPaper('legal', 'landscape')
            ->stream('Envíos.pdf');
        }
    }

    public function getCajas(){
        $bodegas = \App\SQLSRV_Bodega::select('c_bodega','n_bodega')->where('estado','A')->get();
        return Response::json($bodegas);
    }

    public function getCursos(){
        $cursos = \App\SQLSRV_Producto::where('categoria_id',2)->where('estado_id',0)->get();
        return Response::json($cursos);
    }
    public function reporteColegiado($codigo){
        $user = Auth::User();
        $colegiado = \App\SQLSRV_Colegiado::where('c_cliente',$codigo)->first();
        $fecha_actual=Carbon::Now()->endOfMonth();
        $fecha_timbre = Carbon::parse($colegiado->f_ult_timbre)->startOfMonth();
        $diffTimbre = $fecha_timbre->diffInMonths($fecha_actual,false);
        $fecha_colegio = Carbon::parse($colegiado->f_ult_pago)->startOfMonth();
        $diffColegio = $fecha_colegio->diffInMonths($fecha_actual,false);
        if($diffColegio > 3 || $diffTimbre > 3){
            $colegiado->estado = "INACTIVO";
            $calculoReactivacion = $this->calculoReactivacion($colegiado);
            dd($calculoReactivacion);
        }else{
            $colegiado->estado = "ACTIVO";
        }
        if($diffColegio != 0){
            $totalColegiatura= 0;

            $arrayColegiatura= array();
            $mesesColegio = $diffColegio;
            if($mesesColegio < 0){
                $mesesColegio  = abs($mesesColegio);
                $fechaActual = Carbon::Now()->startOfMonth();
                for ($i=0; $i <= $mesesColegio ; $i++) { 
                    $fechaActual->addMonth(1);
                    $mes = $fechaActual->format('m');
                    $año = $fechaActual->format('Y');
                    $mesPago = \App\SigecigMeses::where('id',$mes)->first();
                    $colegiatura = \App\TipoDePago::where('id','11')->first();
                    $colegiatura->tipo_de_pago =  $colegiatura->tipo_de_pago.' ('.$mesPago->mes.' del '.$año.')';
                    $arrayColegiatura[]=$colegiatura;
                    $totalColegiatura += $colegiatura->precio_colegiado;
                }
            }else{
                $fechaActual = $fecha_colegio;
                for ($i=0; $i < $mesesColegio ; $i++) { 
                    $fechaActual->addMonth(1);
                    $mes = $fechaActual->format('m');
                    $año = $fechaActual->format('Y');
                    $mesPago = \App\SigecigMeses::where('id',$mes)->first();
                    $colegiatura = \App\TipoDePago::where('id','11')->first();
                    $colegiatura->tipo_de_pago =  $colegiatura->tipo_de_pago.' ('.$mesPago->mes.' del '.$año.')';
                    $arrayColegiatura[]=$colegiatura;
                    $totalColegiatura += $colegiatura->precio_colegiado;
                } 
            }

            $cuotaColegiado = $mesesColegio * $colegiatura->precio_colegiado;
        }
        if($diffTimbre != 0){
            $totalTimbre= 0;
            $arrayTimbre= array();

            $mesesTimbre = $diffTimbre;

            if($mesesTimbre < 0){
                $mesesTimbre  = abs($mesesTimbre);
                $fechaActual = Carbon::Now()->startOfMonth();
                for ($i=0; $i <= $mesesTimbre ; $i++) { 
                    $fechaActual->addMonth(1);
                    $mes = $fechaActual->format('m');
                    $año = $fechaActual->format('Y');
                    $mesPago = \App\SigecigMeses::where('id',$mes)->first();
                    $timbre = \App\TipoDePago::where('id','62')->first();
                    $timbre->precio_colegiado = $colegiado->monto_timbre;
                    $timbre->tipo_de_pago =  $timbre->tipo_de_pago.' ('.$mesPago->mes.' del '.$año.')';
                    $arrayTimbre[]=$timbre;
                    $totalTimbre += $colegiado->monto_timbre;
                }
            }else{
                $fechaActual = $fecha_timbre;
                for ($i=0; $i < $mesesTimbre ; $i++) { 
                    $fechaActual->addMonth(1);
                    $mes = $fechaActual->format('m');
                    $año = $fechaActual->format('Y');
                    $mesPago = \App\SigecigMeses::where('id',$mes)->first();
                    $timbre = \App\TipoDePago::where('id','62')->first();
                    $timbre->precio_colegiado = $colegiado->monto_timbre;
                    $timbre->tipo_de_pago =  $timbre->tipo_de_pago.' ('.$mesPago->mes.' del '.$año.')';
                    $arrayTimbre[]=$timbre;
                    $totalTimbre += $colegiado->monto_timbre;

                } 
            }
  
        }
       
        $maestros = \App\Recibo_Maestro::select('numero_recibo')->where('numero_de_identificacion',$codigo)->get();
        $arrayDetallesSigecig = array();
        foreach ($maestros as $key => $detalle) {
            $facturaSigecig = \App\Recibo_Maestro::select('sigecig_recibo_maestro.numero_recibo', 'sigecig_recibo_maestro.serie_recibo_id', 'sigecig_recibo_maestro.monto_efecectivo', 'sigecig_recibo_maestro.monto_tarjeta'
            , 'sigecig_recibo_maestro.monto_cheque', 'sigecig_recibo_maestro.monto_deposito', 'sigecig_recibo_maestro.monto_total', 'sigecig_recibo_detalle.cantidad', 'sigecig_recibo_detalle.precio_unitario'
            , 'sigecig_tipo_de_pago.codigo', 'sigecig_tipo_de_pago.tipo_de_pago', 'sigecig_tipo_de_pago.categoria_id','sigecig_recibo_detalle.id_mes','sigecig_recibo_detalle.año','sigecig_recibo_detalle.id'
            , 'sigecig_cajas.nombre_caja', 'sigecig_bodega.nombre_bodega', 'sigecig_subsedes.nombre_sede', 'sigecig_recibo_maestro.created_at', 'sigecig_users.name', 'sigecig_serie_recibo.serie_recibo'
            ,'sigecig_recibo_detalle.total')
            ->join('sigecig_recibo_detalle', 'sigecig_recibo_maestro.numero_recibo', '=', 'sigecig_recibo_detalle.numero_recibo')
            ->join('sigecig_tipo_de_pago', 'sigecig_recibo_detalle.codigo_compra', '=', 'sigecig_tipo_de_pago.codigo')
            ->join('sigecig_cajas', 'sigecig_recibo_maestro.usuario', '=', 'sigecig_cajas.cajero')
            ->join('sigecig_bodega', 'sigecig_cajas.bodega', '=', 'sigecig_bodega.id')
            ->join('sigecig_subsedes', 'sigecig_cajas.subsede', '=', 'sigecig_subsedes.id')
            ->join('sigecig_users', 'sigecig_cajas.cajero', '=', 'sigecig_users.id')
            ->join('sigecig_serie_recibo', 'sigecig_recibo_maestro.serie_recibo_id', '=', 'sigecig_serie_recibo.id')
            ->where('sigecig_recibo_maestro.numero_recibo',$detalle->numero_recibo)
            ->get();
       
            foreach ($facturaSigecig as $key => $dato) {
                if($dato->codigo == 'COL092'){
                    $mes = \App\SigecigMeses::where('id',$dato->id_mes)->first();
                    $dato->tipo_de_pago =  $dato->tipo_de_pago.' ('.$mes->mes.' del '.$dato->año.')';
                }
                if($dato->categoria_id == 1){
                    $numeroTimbres = \App\VentaDeTimbres::where('recibo_detalle_id', $dato->id)->get()->first();
                    if(!empty($numeroTimbres)){
                     $dato->tipo_de_pago = $dato->tipo_de_pago . ' No.';
                       if ($dato->cantidad == 1) {
                       $dato->tipo_de_pago = $dato->tipo_de_pago . ' ' . $numeroTimbres->numeracion_inicial;
                       } else {
                       $dato->tipo_de_pago = $dato->tipo_de_pago . ' ' . $numeroTimbres->numeracion_inicial . '-' . $numeroTimbres->numeracion_final;
                       }
                 
                    }
                }
            }
            $arrayDetallesSigecig[]=$facturaSigecig;
        }
       
 
        


        $facturas = \App\SQLSRV_Fac01::select('control')->where('c_cliente',$codigo)->where('anulado','N')->get();
        $arrayDetalles = array();
        $total = $facturas->sum('total_fac');
        foreach ($facturas as $key => $factura) {
            $detalle = \App\SQLSRV_Fac01::select('fac01.control', 'fac02.codigo','inv02.n_bodega','vdor.n_vendedor','fac01.c_cliente'
            ,'fac01.n_cliente','fac02.descripcion','fac01.serie_f','fac01.num_fac','fac01.efectivo','fac01.cheque','fac01.tarjeta','fac02.importe'
            ,'fac02.precio_u','fac02.cantidad','fac01.fecha1','fac01.total_fac')
            ->join('fac02', 'fac01.control', '=', 'fac02.control')
            ->join('inv02', 'fac01.c_bodega', '=', 'inv02.c_bodega')
            ->join('vdor', 'fac01.c_vendedor', '=', 'vdor.c_vendedor')
            ->where('fac01.control',$factura->control)
            ->orderBy('fac01.control','asc')
            ->get();
            
            $arrayDetalles[]=$detalle;
        }
       
        return \PDF::loadView('admin.estadoCuenta.pdf-reporte-colegiado',compact('user','colegiado','diffTimbre','diffColegio','arrayDetalles','arrayDetallesSigecig','arrayTimbre','arrayColegiatura','totalTimbre','totalColegiatura'))
        ->setPaper('legal', 'landscape')
        ->stream($codigo.'.pdf');




    }


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
