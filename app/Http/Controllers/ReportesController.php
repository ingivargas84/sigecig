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
}
