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
use App\Recibo_Maestro; 
use App\ReciboDeposito; 
use App\Cajas; 
use Carbon\Carbon;
use App\User;
use App\CorteCaja;

class CorteDeCajaController extends Controller
{
    public function index(Recibo_Maestro $id)
    {
        return view('admin.cortecaja.index');
    }

    public function setDetalleCorteCaja(Request $codigo)
    {
       
        $id = $codigo->id;
        $recibom = Recibo_Maestro::whereRaw('Date(created_at) = CURDATE()')->get();
        $deposito = ReciboDeposito::whereRaw('Date(created_at) = CURDATE()')->get();
        $cajaCajero = Cajas::whereRaw('cajero', Auth::user()->id)->get()->first();
        $fecha = Carbon::now();

        $corteCaja=new \App\CorteCaja;
        $corteCaja->monto_total=$recibom->sum('monto_total');
        $corteCaja->total_efectivo=$recibom->sum('monto_efecectivo');
        $corteCaja->total_cheque=$recibom->sum('monto_cheque');
        $corteCaja->total_tarjeta=$recibom->sum('monto_tarjeta');
        $corteCaja->total_deposito=$deposito->sum('monto');
        $corteCaja->id_usuario = Auth::user()->id;
        $corteCaja->id_caja = $cajaCajero->id;
        $corteCaja->fecha_corte=$fecha;
        $recibom->id_corte_de_caja=$corteCaja->id;
        $corteCaja->save(); 
        
      return response()->json(['success' => 'Exito']);
    }

    public function pdf() {

        $recibopdf = Recibo_Maestro::whereRaw('Date(created_at) = CURDATE()')->get();

        $totalespdf = CorteCaja::whereRaw('Date(fecha_corte) = CURDATE()')->get();

        $users = User::where('id', Auth::user()->id)->get()->first();
        $newDate = Carbon::now();
        $pdf = \PDF::loadView('admin.cortecaja.pdfdetalle', compact('users', 'recibopdf', 'totalespdf', 'newDate'));
        return $pdf->stream('DetalleCortedeCaja.pdf');
    }


    public function getDetalle(Request $params)
    {
       $query = "SELECT SUM(RM.monto_efecectivo) as monto_efectivo, SUM(RM.monto_cheque) as montocheque, SUM(RM.monto_tarjeta) as montotarjeta, SUM(RM.monto_total) as montototal, SUM(RD.monto) as montodep
       FROM sigecig_recibo_maestro RM
       LEFT JOIN sigecig_recibo_deposito RD ON RD.numero_recibo = RM.numero_recibo
       WHERE LEFT (RM.created_at,10)=CURDATE()";

       $api_Result['data'] = DB::select($query);
       return Response::json( $api_Result );
    }

    public function getJson(Request $params)
    {
       $query = "SELECT CM.id, RM.serie_recibo_id, RM.numero_recibo, RM.monto_total, RM.created_at, RM.monto_efecectivo, RM.monto_tarjeta, RM.monto_cheque, RD.monto
       FROM sigecig_recibo_maestro RM
       LEFT JOIN sigecig_estado_de_cuenta_maestro CM ON RM.numero_de_identificacion = CM.colegiado_id
       LEFT JOIN sigecig_recibo_deposito RD ON RD.numero_recibo = RM.numero_recibo
       WHERE LEFT (RM.created_at,10)=CURDATE()";

       $api_Result['data'] = DB::select($query);
       return Response::json( $api_Result );
    }
}
