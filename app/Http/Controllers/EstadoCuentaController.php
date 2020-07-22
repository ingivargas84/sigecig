<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use DB;
use \App\EstadoDeCuentaMaestro;
use \App\EstadoDeCuentaDetalle;

use App\SQLSRV_Colegiado;
use App\TipoDePago;
use Carbon\Carbon;






class EstadoCuentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $user = Auth::User();


        return view ('admin.estadoCuenta.cuentamaestro',compact('user'));
    }

    public function getJson()
    {
        //$query=EstadoDeCuentaMaestro::all()->toArray();
        $cuenta = EstadoDeCuentaMaestro::orderBy("colegiado_id", "asc")->pluck('colegiado_id')->toArray();
        $List = implode(', ', $cuenta); 

        $query = "SELECT U.id, CONVERT(INT, U.c_cliente) as cliente, U.n_cliente, U.registro, U.telefono, U.estado, U.fecha_nac, U.f_ult_pago, U.f_ult_timbre
        FROM cc00 U
        WHERE  U.c_cliente IN ($List)
        ORDER BY cliente asc;";
        $result = DB::connection('sqlsrv')->select($query);
        $array=[];
        foreach ($result as $key => $value) {
            $timbrepagado = Carbon::parse($value->f_ult_timbre);
            $mespagado = Carbon::parse($value->f_ult_pago);
            $now = Carbon::now();
            $diffmes = $mespagado->diffInMonths($now, false);
            $difftimbre = $timbrepagado->diffInMonths($now,false);
            if ($diffmes <= 3 || $difftimbre <= 3 ) {
               $value->estado='ACTIVO';
               $array[]= $value;
            }else{
               $value->estado='INACTIVO';
               $array[]= $value;
            }
        }
        $result= $array;
        $array=[];
        foreach ($result as $key => $value) {
            $id=EstadoDeCuentaMaestro::where('colegiado_id',$value->cliente)->get()->first();
            $value->id=$id->id;
            $array[]= $value;
        }
        $api_Result['data'] = $array;
        return Response::json($api_Result);
    }
    public function estadoCuentaDetallado($id){
        $user = Auth::User();
        $cuenta = EstadoDeCuentaDetalle::where('estado_cuenta_maestro_id',$id)->get()->toArray();
        return view ('admin.estadoCuenta.cuentadetalle',compact('user','cuenta'));
    }
}
