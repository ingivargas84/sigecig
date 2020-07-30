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
        $cuenta = EstadoDeCuentaMaestro::orderBy("colegiado_id", "asc")->pluck('colegiado_id')->toArray();
<<<<<<< HEAD
        $List = implode(', ', $cuenta); 
=======
        $List = implode(', ', $cuenta);

>>>>>>> 72e11d4b9840ee42835258044f3636b8b43c72d8
        $query = "SELECT U.id, CONVERT(INT, U.c_cliente) as cliente, U.n_cliente, U.registro, U.telefono, U.estado, U.fecha_nac, U.f_ult_pago, U.f_ult_timbre
        FROM cc00 U
        WHERE  U.c_cliente IN ($List)
        ORDER BY cliente asc;";
        $result = DB::connection('sqlsrv')->select($query);
        $array=[];
        //verificamos el estado del colegiado (Activo o Inactivo)
        foreach ($result as $key => $value) {
            $timbrepagado = Carbon::parse($value->f_ult_timbre);
            $mespagado = Carbon::parse($value->f_ult_pago);
            $now = Carbon::now();
            $diffmes = $mespagado->diffInMonths($now, false);
            $difftimbre = $timbrepagado->diffInMonths($now,false);
            if ($diffmes <= 3 || $difftimbre <= 3 ) {
               $value->estado='Activo';
               $array[]= $value;
            }else{
               $value->estado='Inactivo';
               $array[]= $value;
            }
        }
        $result= $array;
        $array=[];

        foreach ($result as $key => $value) {
            $id=EstadoDeCuentaMaestro::where('colegiado_id',$value->cliente)->get()->first();
            $abono=EstadoDeCuentaDetalle::where('estado_cuenta_maestro_id',$id->id)->sum('abono');
            $cargo=EstadoDeCuentaDetalle::where('estado_cuenta_maestro_id',$id->id)->sum('cargo');
            $total = $cargo-$abono;
            $value->id=$id->id;
            $value->registro= number_format($total, 2, '.', ' ');
            $array[]= $value;
        }
        $api_Result['data'] = $array;
        return Response::json($api_Result);
    }
    public function estadoCuentaDetallado($id){

        $user = Auth::User();
        $no_colegiado=EstadoDeCuentaMaestro::select('colegiado_id')->where('id',$id)->get()->first();
        $colegiado=\App\SQLSRV_Colegiado::select('n_cliente','c_cliente')->where('c_cliente',$no_colegiado->colegiado_id)->get()->first();
        
        return view ('admin.estadoCuenta.cuentadetalle',compact('user','id','colegiado'));
    }

    public function getDetalle($id){

        $query = "SELECT U.id, U.estado_cuenta_maestro_id, U.cantidad,  S.tipo_de_pago, FORMAT(U.abono, 2) as abono, FORMAT(U.cargo, 2 ) as cargo, FORMAT(S.precio_colegiado, 2) as precio_colegiado, U.recibo_id 
        FROM sigecig_estado_de_cuenta_detalle U
        INNER JOIN sigecig_tipo_de_pago S ON U.tipo_pago_id=S.id
        WHERE U.estado_cuenta_maestro_id = $id
        ORDER BY U.id DESC";


        $result = DB::select($query);

        $api_Result['data'] = $result;
        return Response::json($api_Result);
    }
    public function xyz($id){
        $colegiado=\App\SQLSRV_Colegiado::select('n_cliente','c_cliente')->where('c_cliente',$id)->get()->first();
        $user = Auth::User();

        ///
   
        ///
        return view ('admin.estadoCuenta.cardexyz',compact('user','id','colegiado'));
    }
    public function getXyz($id){
        $query = "SELECT U.c_cliente,  U.num_fac, U.n_cliente, S.descripcion ,CONVERT(VARCHAR, CAST(S.importe  AS MONEY), 1) as importe,  CONVERT(VARCHAR, CAST(S.precio_u  AS MONEY), 1) as precio_u, CONVERT(VARCHAR, CAST(S.cantidad  AS MONEY), 1) as cantidad, S.codigo
        FROM fac01 U
        INNER JOIN fac02 S ON U.num_fac=S.num_fac
        WHERE U.c_cliente = '$id'
        ORDER BY U.num_fac DESC";
        $result = DB::connection('sqlsrv')->select($query);
        
        $api_Result['data'] = $result;
        
        return Response::json($api_Result);
    }
}
