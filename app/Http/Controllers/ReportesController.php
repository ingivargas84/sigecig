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
        $reactTimbre=0;
        $reactColegiatura=0;
        $totalTimbre=0;
        $totalColegiatura = 0;
        $user = Auth::User();
        $colegiado = \App\SQLSRV_Colegiado::where('c_cliente',$codigo)->first();
        $fecha_actual=Carbon::Now()->endOfMonth();
        $fecha_timbre = Carbon::parse($colegiado->f_ult_timbre)->endOfMonth();
        $diffTimbre = $fecha_timbre->diffInMonths($fecha_actual,false);
        $fecha_colegio = Carbon::parse($colegiado->f_ult_pago)->endOfMonth();
        $diffColegio = $fecha_colegio->diffInMonths($fecha_actual,false);
        $colegiatura = \App\TipoDePago::where('id','11')->first();
        if($diffColegio > 3 || $diffTimbre > 3){
            $colegiado->estado = "INACTIVO";
            $calculoReactivacion = $colegiado->getMontoReactivacion();
            if($diffTimbre > 3){
                $reactTimbre = 1;
                $arrayTimbre= array();
                $tipoCuota = \App\TipoDePago::where('id','62')->first();
                $fechaTimbre='';
                $detalle = new \stdClass();
                $fechaInicial = Carbon::parse($colegiado->f_ult_timbre)->startOfMonth()->addMonth();
                $fechaFinal = Carbon::parse($colegiado->f_ult_timbre)->startOfMonth()->addMonth($diffTimbre);
                $mesInicial = $fechaInicial->format('m');
                $añoInicial = $fechaInicial->format('Y');
                $mesFinal = $fechaFinal->format('m');
                $añoFinal = $fechaFinal->format('Y');
                $fechaTimbre = ' ('.$mesInicial.' del '.$añoInicial.')'.' al'.' ('.$mesFinal.' del '.$añoFinal.')';
                $detalle->fechaTimbre = $fechaTimbre;
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $colegiado->monto_timbre;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = $calculoReactivacion->cuotasTimbre;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayTimbre[] = $detalle; 
                $detalle = new \stdClass();
                $tipoCuota = \App\TipoDePago::where('codigo','MORT')->first();
                $detalle->fechaTimbre = '';
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $calculoReactivacion->moraTimbre;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = 1;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayTimbre[] = $detalle; 
                $detalle = new \stdClass();
                $tipoCuota = \App\TipoDePago::where('codigo','INTT')->first();
                $detalle->fechaTimbre = '';
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $calculoReactivacion->interesTimbre;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = 1;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayTimbre[] = $detalle;
                $totalTimbre = $calculoReactivacion->totalTimbre;
 
            }
            if($diffColegio > 3){
                $arrayColegiatura =  $colegiado->calcularTipoCuota($calculoReactivacion->capitalColegio,$calculoReactivacion->cuotasColegio);
                $totalColegiatura = $calculoReactivacion->totalColegio;
                $detalle = new \stdClass();
                $tipoCuota = \App\TipoDePago::where('codigo','INTT')->first();
                $detalle->fechaPago = '';
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $calculoReactivacion->interesColegio;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = 1;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayColegiatura[] = $detalle;

            }
            
        }else{
            $colegiado->estado = "ACTIVO";
        }
        if($diffColegio != 0){
            $mesesColegio = $diffColegio;
            if($mesesColegio < 0){
                $arrayColegiatura= array();
                $tipoCuota = \App\TipoDePago::where('categoria_id',3)->where('tipo_colegiatura',1)->where('estado',0)->orderBy('id', 'desc')->get()->first();
                $fechaPago='';
                $mesesColegio  = abs($mesesColegio);
                $detalle = new \stdClass();
                $fechaInicial = Carbon::Now()->startOfMonth()->addMonth(1);
                $fechaFinal = Carbon::Now()->startOfMonth()->addMonth($mesesColegio);
                $mesInicial = $fechaInicial->format('m');
                $añoInicial = $fechaInicial->format('Y');
                $mesFinal = $fechaFinal->format('m');
                $añoFinal = $fechaFinal->format('Y');
                if($mesesColegio == 1){
                    $fechaPago = ' ('.$mesInicial.' del '.$añoInicial.')';
                }else{
                    $fechaPago = ' ('.$mesInicial.' del '.$añoInicial.')'.' al'.' ('.$mesFinal.' del '.$añoFinal.')';
                }
                $detalle->fechaPago = $fechaPago;
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $tipoCuota->precio_colegiado;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = $mesesColegio;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayColegiatura[]=$detalle;
                $totalColegiatura = $detalle->total;


            }
            else if($mesesColegio < 4){
                $arrayColegiatura= array();
                $tipoCuota = \App\TipoDePago::where('categoria_id',3)->where('tipo_colegiatura',1)->where('estado',0)->orderBy('id', 'desc')->get()->first();
                $fechaPago='';
                $detalle = new \stdClass();
                $fechaInicial = Carbon::parse($colegiado->f_ult_pago)->startOfMonth()->addMonth(1);
                $fechaFinal = Carbon::parse($colegiado->f_ult_pago)->startOfMonth()->addMonth($mesesColegio);
                $mesInicial = $fechaInicial->format('m');
                $añoInicial = $fechaInicial->format('Y');
                $mesFinal = $fechaFinal->format('m');
                $añoFinal = $fechaFinal->format('Y');
                if($mesesColegio == 1){
                    $fechaPago = ' ('.$mesInicial.' del '.$añoInicial.')';
                }else{
                    $fechaPago = ' ('.$mesInicial.' del '.$añoInicial.')'.' al'.' ('.$mesFinal.' del '.$añoFinal.')';
                }
                $detalle->fechaPago = $fechaPago;
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $tipoCuota->precio_colegiado;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = $mesesColegio;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayColegiatura[]=$detalle;
                $totalColegiatura = $detalle->total;

            }

        }
        if($diffTimbre != 0){

            $mesesTimbre = $diffTimbre;

            if($mesesTimbre < 0){
                $arrayTimbre= array();
                $tipoCuota = \App\TipoDePago::where('id','62')->first();
                $fechaTimbre='';
                $mesesTimbre  = abs($mesesTimbre);
                $detalle = new \stdClass();
                $fechaInicial = Carbon::Now()->startOfMonth()->addMonth();
                $fechaFinal = Carbon::Now()->startOfMonth()->addMonth($mesesTimbre);
                $mesInicial = $fechaInicial->format('m');
                $añoInicial = $fechaInicial->format('Y');
                $mesFinal = $fechaFinal->format('m');
                $añoFinal = $fechaFinal->format('Y');
                if($mesesTimbre == 1){
                    $fechaTimbre = ' ('.$mesInicial.' del '.$añoInicial.')';
                }else{
                    $fechaTimbre = ' ('.$mesInicial.' del '.$añoInicial.')'.' al'.' ('.$mesFinal.' del '.$añoFinal.')';
                }
                $detalle->fechaTimbre = $fechaTimbre;
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $colegiado->monto_timbre;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = $mesesTimbre;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayTimbre[]=$detalle;
                $totalTimbre = $detalle->total;


            }
            else if($mesesTimbre < 4 ){
                $arrayTimbre= array();
                $tipoCuota = \App\TipoDePago::where('id','62')->first();
                $fechaTimbre='';
                $mesesTimbre  = abs($mesesTimbre);
                $detalle = new \stdClass();
                $fechaInicial = Carbon::parse($colegiado->f_ult_timbre)->startOfMonth()->addMonth();
                $fechaFinal = Carbon::parse($colegiado->f_ult_timbre)->startOfMonth()->addMonth($mesesTimbre);
                $mesInicial = $fechaInicial->format('m');
                $añoInicial = $fechaInicial->format('Y');
                $mesFinal = $fechaFinal->format('m');
                $añoFinal = $fechaFinal->format('Y');
                if($mesesTimbre == 1){
                    $fechaTimbre = ' ('.$mesInicial.' del '.$añoInicial.')';
                }else{
                    $fechaTimbre = ' ('.$mesInicial.' del '.$añoInicial.')'.' al'.' ('.$mesFinal.' del '.$añoFinal.')';
                }
                $detalle->fechaTimbre = $fechaTimbre;
                $detalle->tipoPago = $tipoCuota->tipo_de_pago;
                $detalle->precio = $colegiado->monto_timbre;
                $detalle->codigo = $tipoCuota->codigo;
                $detalle->cantidad = $mesesTimbre;
                $detalle->total = $detalle->cantidad * $detalle->precio;
                $arrayTimbre[] = $detalle; 
                $totalTimbre = $detalle->total;

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
       
        return \PDF::loadView('admin.estadoCuenta.pdf-reporte-colegiado',compact('user','colegiado','diffTimbre','diffColegio','arrayDetalles','arrayDetallesSigecig','arrayTimbre','arrayColegiatura','reactColegiatura','totalTimbre','totalColegiatura'))
        ->setPaper('legal', 'landscape')
        ->stream($codigo.'.pdf');




    }
    public function pruebas(){
        $cuenta = \App\EstadoDeCuentaMaestro::orderBy("colegiado_id", "asc")->get();
        $servicio = \App\TipoDePago::where('id','11')->get()->first();
        $timbre = \App\TipoDePago::where('id','23')->get()->first();

        foreach ($cuenta as $key => $value) {
            $colegiado=\App\SQLSRV_Colegiado::where('c_cliente',$value->colegiado_id)->get()->first();
            $calculoReactivacion = $colegiado->getMontoReactivacion();
            dd($calculoReactivacion);
            $timbres = $colegiado->codigosTimbrePago('1');
            $cuentaD = \App\EstadoDeCuentaDetalle::create([
                'estado_cuenta_maestro_id'      => $value->id,
                'cantidad'                      => '1',
                'tipo_pago_id'                  => $servicio->id,
                'recibo_id'                     => '1',
                'abono'                         => '0.00',
                'cargo'                         => $servicio->precio_colegiado,
                'usuario_id'                    => '1',
                'estado_id'                     => '1',
            ]);
            foreach ($timbres as $key => $timbre) {
                $timbreColegiado = \App\EstadoDeCuentaDetalle::create([
                    'estado_cuenta_maestro_id'      => $value->id,
                    'cantidad'                      => $timbre->cantidad,
                    'tipo_pago_id'                  => $timbre->id,
                    'recibo_id'                     => '1',
                    'abono'                         => '0.00',
                    'cargo'                         => $timbre->total,
                    'usuario_id'                    => '1',
                    'estado_id'                     => '1',
                ]);
            }

         

        }
    }


  
    
}
