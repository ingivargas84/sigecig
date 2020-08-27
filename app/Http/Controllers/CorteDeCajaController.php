<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
/* use \App\EstadoDeCuentaMaestro;
use \App\EstadoDeCuentaDetalle;
use App\SigecigSaldoColegiados;
use App\SQLSRV_Colegiado;
use App\TipoDePago;*/
use App\Recibo_Maestro; 
use Carbon\Carbon;
use App\User;
use App\CorteCaja;

class CorteDeCajaController extends Controller
{
    public function index(Recibo_Maestro $id)
    {
        return view('admin.cortecaja.index');
    }

    public function new()
    {
        $query = "SELECT CM.id, RM.serie_recibo_id, RM.numero_recibo, RM.monto_total, RM.created_at, RM.monto_efecectivo, RM.monto_tarjeta, RM.monto_cheque
        FROM sigecig_recibo_maestro RM
        INNER JOIN sigecig_estado_de_cuenta_maestro CM ON RM.numero_de_identificacion = CM.colegiado_id
        WHERE LEFT (RM.created_at,10)=CURDATE()";
 
        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );

        $query2 = "SELECT SUM(RM.monto_efecectivo) as monto_efectivo, SUM(RM.monto_cheque) as montocheque, SUM(RM.monto_tarjeta) as montotarjeta, SUM(RM.monto_total) as montototal
        FROM sigecig_recibo_maestro RM
        WHERE LEFT (RM.created_at,10)=CURDATE()";
 
        $api_Result['data'] = DB::select($query2);
        return Response::json( $api_Result );

        return view('admin.cortecaja.nuevo', compact ('query', 'query2'));
    }

    public function setDetalleCorteCaja(Request $request)
    {
        $recibom = \App\Recibo_Maestro::find('id');
        $cortedecaja = new \App\CorteCaja;

        $query = "INSERT INTO sigecig_corte_de_caja (monto_total, total_efectivo, total_cheque
        SELECT SUM(RM.monto_total) as montototal, SUM(RM.monto_efecectivo) as monto_efectivo, SUM(RM.monto_cheque) as montocheque, SUM(RM.monto_tarjeta) as montotarjeta isnull(n_profesion,'') 
        from sigecig_recibo_maestro RM
        WHERE LEFT (RM.created_at,10)=CURDATE()";
        $api_Result['data'] = DB::insert($query);

       /*  $corte=new CorteCaja;
        $corte->monto_total=$request->get('monto_total');
        $corte->total_efectivo=$request->get('total_efectivo');
        $corte->total_cheque=$request->get('total_cheque');
        $corte->total_tarjeta=$request->get('total_tarjeta');
        $corte->total_deposito=$request->get('total_deposito');
        $corte->id_caja=$request->get('id_caja');
        $corte->id_usuario=$request->get('id_usuario');
        $corte->fecha_corte=$request->get('fecha_corte');
        $corte->save(); */

/*         event(new ActualizacionBitacora(1, Auth::user()->id,'creacion', '', $cajas, 'Cajas' ));
 */        return response()->json(['success' => 'Exito']);
    }

    public function pdf() {
   /*      
        $query = "SELECT RM.id
       FROM sigecig_recibo_maestro RM
       WHERE LEFT (RM.created_at,10)=CURDATE()"; 


       $query = "SELECT SUM(RM.monto_efecectivo) as monto_efectivo, SUM(RM.monto_cheque) as montocheque, SUM(RM.monto_tarjeta) as montotarjeta, SUM(RM.monto_total) as montototal
       FROM sigecig_recibo_maestro RM
       WHERE LEFT (RM.created_at,10)=CURDATE()";

       $api_Result['data'] = DB::select($query);*/

        $pdf = \PDF::loadView('admin.cortecaja.pdfdetalle');
        return $pdf->stream('DetalleCortedeCaja.pdf');
    }

    public function getDetalle(Request $params)
    {
       $query = "SELECT SUM(RM.monto_efecectivo) as monto_efectivo, SUM(RM.monto_cheque) as montocheque, SUM(RM.monto_tarjeta) as montotarjeta, SUM(RM.monto_total) as montototal
       FROM sigecig_recibo_maestro RM
       WHERE LEFT (RM.created_at,10)=CURDATE()";

       $api_Result['data'] = DB::select($query);
       return Response::json( $api_Result );
    }

    public function getJson(Request $params)
    {
       $query = "SELECT CM.id, RM.serie_recibo_id, RM.numero_recibo, RM.monto_total, RM.created_at, RM.monto_efecectivo, RM.monto_tarjeta, RM.monto_cheque
       FROM sigecig_recibo_maestro RM
       LEFT JOIN sigecig_estado_de_cuenta_maestro CM ON RM.numero_de_identificacion = CM.colegiado_id
       WHERE LEFT (RM.created_at,10)=CURDATE()";

       $api_Result['data'] = DB::select($query);
       return Response::json( $api_Result );
    }
}
