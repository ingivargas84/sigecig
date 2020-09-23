<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ReportesController extends Controller
{
    public function reporteVentasXyz(Request $request){
        $user = Auth::User();
        $fechaInicial=Carbon::parse($request->fechaInicialVenta)->startOfDay()->toDateString();
        $fechaFinal=Carbon::parse($request->fechaFinalVenta)->endOfDay()->toDateString();

        $facturas=\App\SQLSRV_Fac01::select('num_fac','serie_f','total_fac','control')->whereBetween('fecha1', [$fechaInicial, $fechaFinal])->where('anulado','N')->get();
        $total = $facturas->sum('total_fac');

        $arrayDetalles = array();
  
            
            foreach ($facturas as $key => $factura) {
                        $query = "SELECT  U.total_fac, U.c_cliente, b.n_bodega, U.serie_f,  U.num_fac, U.n_cliente,FORMAT( U.fecha1, 'dd/MM/yyyy h:m:s', 'en-US' ) AS 'fecha',S.descripcion ,
                        CONVERT(VARCHAR, CAST(S.importe  AS MONEY), 1) as importe,  CONVERT(VARCHAR, CAST(S.precio_u  AS MONEY), 1) as precio_u, 
                        CONVERT(VARCHAR, CAST(S.cantidad  AS MONEY), 1) as cantidad,  S.codigo, V.n_vendedor, U.efectivo, U.tarjeta, U.cheque, S.codigo
                        FROM fac01 U
                        INNER JOIN fac02 S ON U.num_fac=S.num_fac
                        INNER JOIN vdor v ON V.c_vendedor = U.c_vendedor
                        INNER JOIN inv02 b ON b.c_bodega = U.c_bodega
                        WHERE U.num_fac = '$factura->num_fac' AND (U.fecha1) BETWEEN CAST('$fechaInicial' AS DATE) AND CAST('$fechaFinal' AS DATE)
                        AND S.serie_f = '$factura->serie_f' AND S.control = '$factura->control'
                        ORDER BY U.num_fac ASC";
                        $result = DB::connection('sqlsrv')->select($query);
               if(!empty($result)){
                $arrayDetalles[]=$result; 
               }
          
            }
            return \PDF::loadView('admin.reportes.pdf-reporte-ventas-xyz',compact('arrayDetalles','fechaInicial','fechaFinal','user','total'))
            ->setPaper('legal', 'landscape')
            ->stream('Traspaso.pdf');
  
    }

    public function reporteEnvios(Request $request){
        $user = Auth::User();
        $fechaInicial=Carbon::parse($request->fechaInicialVenta)->startOfDay()->toDateString();
        $fechaFinal=Carbon::parse($request->fechaFinalVenta)->endOfDay()->toDateString();
        $facturas=\App\SQLSRV_Fac01::select('num_fac','serie_f','total_fac','control')->whereBetween('fecha1', [$fechaInicial, $fechaFinal])->get();

    //    dd($request);
    //    $cuenta1 = SQLSRV_Colegiado::select('cc00.c_cliente', 'cc00.n_cliente', 'cc00.registro', 'cc00prof.n_profesion', 'cc00.telefono', 'cc00.fecha_nac', 'cc00.f_ult_pago', 'cc00.f_ult_timbre')
    //    ->join('cc00prof', 'cc00.c_cliente', '=', 'cc00prof.c_cliente')
    //    ->whereIn('cc00.c_cliente', $cuenta)->orderBy('c_cliente','asc')
    //    ->get();


    }
}
