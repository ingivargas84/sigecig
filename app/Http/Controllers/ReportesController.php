<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class ReportesController extends Controller
{
    public function reporteVentasXyz(Request $request){

        $fechaInicial=Carbon::parse($request->fechaInicialVenta)->startOfDay()->toDateString();
        $fechaFinal=Carbon::parse($request->fechaFinalVenta)->endOfDay()->toDateString();

        // $query = "SELECT U.c_cliente, U.serie_f,  U.num_fac, U.n_cliente,FORMAT( U.fecha1, 'dd/MM/yyyy h:m:s', 'en-US' ) AS 'fecha',S.descripcion ,
        // CONVERT(VARCHAR, CAST(S.importe  AS MONEY), 1) as importe,  CONVERT(VARCHAR, CAST(S.precio_u  AS MONEY), 1) as precio_u, 
        // CONVERT(VARCHAR, CAST(S.cantidad  AS MONEY), 1) as cantidad,  S.codigo, V.n_vendedor, U.efectivo, U.tarjeta, U.cheque, S.codigo
        // FROM fac01 U
        // INNER JOIN fac02 S ON U.num_fac=S.num_fac
        // INNER JOIN vdor v ON V.c_vendedor = U.c_vendedor
        // WHERE (U.fecha1) BETWEEN CAST('$fechaInicial' AS DATE) AND CAST('$fechaFinal' AS DATE)
        // ORDER BY U.num_fac ASC";
        // $result = DB::connection('sqlsrv')->select($query);

        $facturas=\App\SQLSRV_Fac01::select('num_fac')->whereBetween('fecha1', [$fechaInicial, $fechaFinal])->get();

        $arrayDetalles = array();
  
            
            foreach ($facturas as $key => $factura) {
                $detalles = \App\SQLSRV_Fac02::where('num_fac',$factura->num_fac)->get();
                $arrayDetalles[]=$detalles; 
            }
            
      

        dd($arrayDetalles);
        // $query = "SELECT U.num_fac 
        // FROM fac01 U
        // INNER JOIN fac02 S ON U.num_fac=S.num_fac
        // WHERE (U.fecha1) BETWEEN CAST('$fechaInicial' AS DATE) AND CAST('$fechaFinal' AS DATE)
        // ORDER BY U.num_fac ASC";
        // $maestros = DB::connection('sqlsrv')->select($query);
       
    



        // $ventaTimbres= "SELECT reciboDetalle.cantidad, reciboDetalle.codigo_compra, reciboDetalle.total
        // FROM sigecig_recibo_maestro reciboMaestro
        // INNER JOIN sigecig_recibo_detalle reciboDetalle ON reciboDetalle.numero_recibo = reciboMaestro.numero_recibo
        // WHERE reciboMaestro.usuario = $caja->cajero AND reciboDetalle.codigo_compra = '$tipoPagosCategoria->codigo'
        // AND DATE(reciboDetalle.created_at) BETWEEN CAST('$fechaInicialVenta' AS DATE) AND CAST('$fechaFinalVenta' AS DATE);";
        // $ventaMaestro = DB::select($ventaTimbres);
        
       dd($result);
  
    }
}
